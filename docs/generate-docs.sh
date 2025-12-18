#!/bin/bash

# GegoK12 Documentation Generator Script
# Generates comprehensive phpDoc documentation using PHPDocumentor

SCRIPT_DIR="$( cd "$( dirname "${BASH_SOURCE[0]}" )" && pwd )"
PROJECT_ROOT="$(dirname "$SCRIPT_DIR")"
PHPDOC_URL="https://phpdoc.org/phpdoc.phar"
PHPDOC_FILE="$PROJECT_ROOT/phpdoc.phar"
CONFIG_FILE="$SCRIPT_DIR/phpdoc.xml"
OUTPUT_DIR="$PROJECT_ROOT/storage/phpdoc"

echo "📚 GegoK12 Documentation Generator"
echo "=================================="
echo ""

# Check if PHPDocumentor PHAR exists
if [ ! -f "$PHPDOC_FILE" ]; then
    echo "⬇️  Downloading PHPDocumentor..."
    curl -L "$PHPDOC_URL" -o "$PHPDOC_FILE"
    if [ $? -ne 0 ]; then
        echo "❌ Failed to download PHPDocumentor"
        exit 1
    fi
    chmod +x "$PHPDOC_FILE"
    echo "✅ PHPDocumentor downloaded"
else
    echo "✅ PHPDocumentor already available"
fi

echo ""
echo "📖 Generating documentation..."
echo "   Source: $PROJECT_ROOT/app"
echo "   Output: $OUTPUT_DIR"
echo "   Config: $CONFIG_FILE"
echo ""

# Create output directory if it doesn't exist
mkdir -p "$OUTPUT_DIR"

# Generate documentation
cd "$PROJECT_ROOT"
"$PHPDOC_FILE" -d ./app -t "$OUTPUT_DIR" --config="$CONFIG_FILE"

if [ $? -eq 0 ]; then
    echo ""
    echo "✅ Documentation generated successfully!"
    echo ""
    echo "📂 Output location: $OUTPUT_DIR"
    echo ""
    echo "🌐 Viewing options:"
    echo "   1. Open in browser (macOS):  open $OUTPUT_DIR/index.html"
    echo "   2. Python server:            cd $OUTPUT_DIR && python3 -m http.server 8000"
    echo "   3. PHP server:               cd $OUTPUT_DIR && php -S localhost:8000"
    echo ""
    echo "Opening documentation in browser..."

    if [[ "$OSTYPE" == "darwin"* ]]; then
        open "$OUTPUT_DIR/index.html"
    elif [[ "$OSTYPE" == "linux-gnu"* ]]; then
        if command -v xdg-open &> /dev/null; then
            xdg-open "$OUTPUT_DIR/index.html"
        fi
    fi
else
    echo ""
    echo "❌ Failed to generate documentation"
    exit 1
fi
