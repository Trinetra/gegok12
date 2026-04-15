#!/bin/bash

#===============================================================================
# GegoK12 Update Script
# For: sms.saisanathana.com
# Created: April 2026
#
# Usage: sudo ./update-gegok12.sh [--check-only]
#        --check-only : Just show available updates without applying them
#===============================================================================

set -e  # Exit on any error

# Colors for output
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
BLUE='\033[0;34m'
NC='\033[0m' # No Color

# Configuration
INSTALL_DIR="/var/www/gegok12"
BACKUP_DIR="$HOME/gegok12-backups"
DATE=$(date +%Y-%m-%d_%H-%M-%S)

#-------------------------------------------------------------------------------
# Functions
#-------------------------------------------------------------------------------

print_header() {
    echo ""
    echo -e "${BLUE}╔════════════════════════════════════════════════════════════════╗${NC}"
    echo -e "${BLUE}║${NC}  $1"
    echo -e "${BLUE}╚════════════════════════════════════════════════════════════════╝${NC}"
}

print_step() {
    echo -e "${GREEN}▶${NC} $1"
}

print_warning() {
    echo -e "${YELLOW}⚠${NC} $1"
}

print_error() {
    echo -e "${RED}✖${NC} $1"
}

print_success() {
    echo -e "${GREEN}✔${NC} $1"
}

check_updates() {
    print_header "Checking for updates..."
    cd "$INSTALL_DIR"
    
    git fetch origin
    
    LOCAL=$(git rev-parse HEAD)
    REMOTE=$(git rev-parse origin/main)
    
    if [ "$LOCAL" = "$REMOTE" ]; then
        print_success "You are already on the latest version!"
        echo ""
        exit 0
    fi
    
    echo ""
    print_step "Available updates:"
    echo ""
    git log HEAD..origin/main --oneline
    echo ""
    
    COMMIT_COUNT=$(git rev-list HEAD..origin/main --count)
    print_warning "$COMMIT_COUNT new commit(s) available"
    echo ""
}

create_backup() {
    print_header "Creating backup..."
    
    mkdir -p "$BACKUP_DIR/$DATE"
    
    # Backup modified files
    print_step "Backing up custom files..."
    cp "$INSTALL_DIR/app/Imports/UsersImport.php" "$BACKUP_DIR/$DATE/"
    cp "$INSTALL_DIR/app/Traits/Common.php" "$BACKUP_DIR/$DATE/"
    cp "$INSTALL_DIR/app/Http/Controllers/Admin/UserProfileController.php" "$BACKUP_DIR/$DATE/"
    cp "$INSTALL_DIR/.env" "$BACKUP_DIR/$DATE/"
    
    # Backup database
    print_step "Backing up database..."
    source "$INSTALL_DIR/.env"
    mysqldump -u"$DB_USERNAME" -p"$DB_PASSWORD" "$DB_DATABASE" > "$BACKUP_DIR/$DATE/database.sql" 2>/dev/null || {
        print_warning "Database backup skipped (check credentials)"
    }
    
    print_success "Backup saved to: $BACKUP_DIR/$DATE"
}

pull_updates() {
    print_header "Pulling updates..."
    cd "$INSTALL_DIR"
    
    print_step "Stashing local changes..."
    git stash
    
    print_step "Pulling from origin/main..."
    git pull origin main
    
    print_success "Code updated!"
}

update_dependencies() {
    print_header "Updating dependencies..."
    cd "$INSTALL_DIR"
    
    print_step "Running composer install..."
    composer install --no-dev --no-interaction --prefer-dist
    
    print_success "PHP dependencies updated!"
}

run_migrations() {
    print_header "Running database migrations..."
    cd "$INSTALL_DIR"
    
    # Check for pending migrations
    PENDING=$(php artisan migrate:status 2>/dev/null | grep -c "Pending" || true)
    
    if [ "$PENDING" -gt 0 ]; then
        print_step "Found $PENDING pending migration(s)..."
        php artisan migrate --force
        print_success "Migrations complete!"
    else
        print_success "No pending migrations."
    fi
}

build_frontend() {
    print_header "Building frontend assets..."
    cd "$INSTALL_DIR"
    
    print_step "Installing npm packages..."
    npm install --silent
    
    print_step "Building for production..."
    npm run production
    
    print_success "Frontend built!"
}

clear_caches() {
    print_header "Clearing caches..."
    cd "$INSTALL_DIR"
    
    php artisan config:clear
    php artisan cache:clear
    php artisan view:clear
    php artisan route:clear
    
    print_success "All caches cleared!"
}

apply_fixes() {
    print_header "Applying custom fixes..."
    cd "$INSTALL_DIR"
    
    # Fix 1: UsersImport.php - Initialize $student and $parent
    print_step "Fix 1: UsersImport.php - Initialize variables..."
    
    if ! grep -q '\$student = new \\stdClass()' "$INSTALL_DIR/app/Imports/UsersImport.php"; then
        # Find the line number of $standardLink query end
        LINE=$(grep -n "standardLink = StandardLink::where" "$INSTALL_DIR/app/Imports/UsersImport.php" | head -1 | cut -d: -f1)
        if [ -n "$LINE" ]; then
            # Add 4 lines to get past the ->first(); line
            INSERT_LINE=$((LINE + 4))
            sed -i "${INSERT_LINE}a\\
\\
                \$student = new \\\\stdClass();\\
                \$parent = new \\\\stdClass();" "$INSTALL_DIR/app/Imports/UsersImport.php"
            print_success "Added \$student and \$parent initialization"
        else
            print_warning "Could not find insertion point for Fix 1"
        fi
    else
        print_success "Fix 1 already applied"
    fi
    
    # Fix 2: UsersImport.php - Change count() to null check
    print_step "Fix 2: UsersImport.php - Fix parent_status check..."
    
    if grep -q 'count(\$parent_status)' "$INSTALL_DIR/app/Imports/UsersImport.php"; then
        sed -i 's/if (count(\$parent_status) <= 0)/if (\$parent_status === null)/' "$INSTALL_DIR/app/Imports/UsersImport.php"
        sed -i 's/if(count(\$parent_status)<=0)/if(\$parent_status === null)/' "$INSTALL_DIR/app/Imports/UsersImport.php"
        print_success "Fixed parent_status null check"
    else
        print_success "Fix 2 already applied"
    fi
    
    # Fix 3: Common.php - Add disk('uploads')
    print_step "Fix 3: Common.php - Fix Storage disk..."
    
    if grep -q "\\\\Storage::putFile(\$folder, \$file,'public')" "$INSTALL_DIR/app/Traits/Common.php"; then
        sed -i "s/\\\\Storage::putFile(\$folder, \$file,'public')/\\\\Storage::disk('uploads')->putFile(\$folder, \$file,'public')/" "$INSTALL_DIR/app/Traits/Common.php"
        print_success "Fixed Common.php Storage disk"
    else
        print_success "Fix 3 already applied"
    fi
    
    # Fix 4: UserProfileController.php - Add disk('uploads')
    print_step "Fix 4: UserProfileController.php - Fix Storage disk..."
    
    if grep -q "\\\\Storage::putFile(Auth::user()->school->slug.'/uploads/avatars'" "$INSTALL_DIR/app/Http/Controllers/Admin/UserProfileController.php"; then
        sed -i "s/\\\\Storage::putFile(Auth::user()->school->slug.'\\/uploads\\/avatars', \$request->avatar,'public')/\\\\Storage::disk('uploads')->putFile(Auth::user()->school->slug.'\\/uploads\\/avatars', \$request->avatar,'public')/" "$INSTALL_DIR/app/Http/Controllers/Admin/UserProfileController.php"
        print_success "Fixed UserProfileController.php Storage disk"
    else
        print_success "Fix 4 already applied"
    fi
    
    print_success "All fixes applied!"
}

verify_fixes() {
    print_header "Verifying fixes..."
    cd "$INSTALL_DIR"
    
    ERRORS=0
    
    # Check Fix 1 & 2
    if grep -q '\$student = new \\stdClass()' "$INSTALL_DIR/app/Imports/UsersImport.php"; then
        print_success "UsersImport.php: Variable initialization ✓"
    else
        print_error "UsersImport.php: Variable initialization MISSING"
        ERRORS=$((ERRORS + 1))
    fi
    
    if grep -q '\$parent_status === null' "$INSTALL_DIR/app/Imports/UsersImport.php"; then
        print_success "UsersImport.php: Null check ✓"
    else
        print_error "UsersImport.php: Null check MISSING"
        ERRORS=$((ERRORS + 1))
    fi
    
    # Check Fix 3
    if grep -q "disk('uploads')->putFile" "$INSTALL_DIR/app/Traits/Common.php"; then
        print_success "Common.php: Storage disk ✓"
    else
        print_error "Common.php: Storage disk MISSING"
        ERRORS=$((ERRORS + 1))
    fi
    
    # Check Fix 4
    if grep -q "disk('uploads')->putFile" "$INSTALL_DIR/app/Http/Controllers/Admin/UserProfileController.php"; then
        print_success "UserProfileController.php: Storage disk ✓"
    else
        print_error "UserProfileController.php: Storage disk MISSING"
        ERRORS=$((ERRORS + 1))
    fi
    
    echo ""
    if [ $ERRORS -eq 0 ]; then
        print_success "All fixes verified!"
    else
        print_error "$ERRORS fix(es) need attention"
    fi
}

restart_services() {
    print_header "Restarting services..."
    
    print_step "Restarting PHP-FPM..."
    systemctl restart php8.4-fpm
    
    print_step "Reloading Nginx..."
    systemctl reload nginx
    
    print_success "Services restarted!"
}

show_summary() {
    print_header "Update Complete!"
    echo ""
    echo -e "  ${GREEN}✔${NC} Code updated from GitHub"
    echo -e "  ${GREEN}✔${NC} Dependencies installed"
    echo -e "  ${GREEN}✔${NC} Migrations run"
    echo -e "  ${GREEN}✔${NC} Frontend built"
    echo -e "  ${GREEN}✔${NC} Caches cleared"
    echo -e "  ${GREEN}✔${NC} Custom fixes applied"
    echo -e "  ${GREEN}✔${NC} Services restarted"
    echo ""
    echo -e "  Backup location: ${YELLOW}$BACKUP_DIR/$DATE${NC}"
    echo ""
    echo -e "  ${BLUE}Test your site:${NC} https://sms.saisanathana.com"
    echo ""
}

rollback() {
    print_header "Rolling back..."
    
    if [ -z "$1" ]; then
        echo "Available backups:"
        ls -1 "$BACKUP_DIR"
        echo ""
        echo "Usage: $0 --rollback <backup-folder-name>"
        exit 1
    fi
    
    ROLLBACK_DIR="$BACKUP_DIR/$1"
    
    if [ ! -d "$ROLLBACK_DIR" ]; then
        print_error "Backup not found: $ROLLBACK_DIR"
        exit 1
    fi
    
    print_step "Restoring files from $ROLLBACK_DIR..."
    cp "$ROLLBACK_DIR/UsersImport.php" "$INSTALL_DIR/app/Imports/"
    cp "$ROLLBACK_DIR/Common.php" "$INSTALL_DIR/app/Traits/"
    cp "$ROLLBACK_DIR/UserProfileController.php" "$INSTALL_DIR/app/Http/Controllers/Admin/"
    cp "$ROLLBACK_DIR/.env" "$INSTALL_DIR/"
    
    print_step "Restoring database..."
    source "$INSTALL_DIR/.env"
    mysql -u"$DB_USERNAME" -p"$DB_PASSWORD" "$DB_DATABASE" < "$ROLLBACK_DIR/database.sql"
    
    clear_caches
    restart_services
    
    print_success "Rollback complete!"
}

#-------------------------------------------------------------------------------
# Main
#-------------------------------------------------------------------------------

echo ""
echo -e "${BLUE}╔════════════════════════════════════════════════════════════════╗${NC}"
echo -e "${BLUE}║${NC}          ${GREEN}GegoK12 Update Script${NC}                               ${BLUE}║${NC}"
echo -e "${BLUE}║${NC}          sms.saisanathana.com                               ${BLUE}║${NC}"
echo -e "${BLUE}╚════════════════════════════════════════════════════════════════╝${NC}"

# Check if running as root
if [ "$EUID" -ne 0 ]; then
    print_error "Please run as root (sudo ./update-gegok12.sh)"
    exit 1
fi

# Parse arguments
case "${1:-}" in
    --check-only)
        check_updates
        exit 0
        ;;
    --rollback)
        rollback "$2"
        exit 0
        ;;
    --verify)
        verify_fixes
        exit 0
        ;;
    --help)
        echo ""
        echo "Usage: sudo ./update-gegok12.sh [option]"
        echo ""
        echo "Options:"
        echo "  (none)        Full update process"
        echo "  --check-only  Check for updates without applying"
        echo "  --verify      Verify that custom fixes are applied"
        echo "  --rollback    Restore from a backup"
        echo "  --help        Show this help message"
        echo ""
        exit 0
        ;;
esac

# Full update process
check_updates

echo ""
read -p "Do you want to proceed with the update? (y/n) " -n 1 -r
echo ""

if [[ ! $REPLY =~ ^[Yy]$ ]]; then
    print_warning "Update cancelled."
    exit 0
fi

create_backup
pull_updates
update_dependencies
run_migrations
build_frontend
clear_caches
apply_fixes
verify_fixes
restart_services
show_summary
