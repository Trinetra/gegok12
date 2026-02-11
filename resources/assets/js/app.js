
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

require('./custom_addon');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */
// require('./inventory');
Vue.component('example-component', () => import('./components/ExampleComponent.vue').then(m => m.default));

//demo
Vue.component('demo-tab', () => import('./components/demo/Tab.vue').then(m => m.default));

//admission
Vue.component('admission-list', () => import('./components/admission/List.vue').then(m => m.default));
Vue.component('edit-admission-form', () => import('./components/admission/Edit.vue').then(m => m.default));
Vue.component('add-admission', () => import('./components/admission/AdmissionTab.vue').then(m => m.default));
Vue.component('select-standard', () => import('./components/admission/SelectStandard.vue').then(m => m.default));
Vue.component('student-detail', () => import('./components/admission/StudentDetail.vue').then(m => m.default));
Vue.component('academic-detail', () => import('./components/admission/AcademicDetail.vue').then(m => m.default));
Vue.component('parent-detail', () => import('./components/admission/ParentDetail.vue').then(m => m.default));
Vue.component('personal-detail', () => import('./components/admission/PersonalDetail.vue').then(m => m.default));



// classwall

	//page
	Vue.component('page-list', () => import('./components/classwall/page/List.vue').then(m => m.default));
	Vue.component('create-page', () => import('./components/classwall/page/Create.vue').then(m => m.default));
	Vue.component('edit-page', () => import('./components/classwall/page/Edit.vue').then(m => m.default));
	Vue.component('show-page', () => import('./components/classwall/page/Show.vue').then(m => m.default));
	Vue.component('page-tab', () => import('./components/classwall/page/tabs/pageTab.vue').then(m => m.default));

	//post
	Vue.component('post-list', () => import('./components/classwall/post/List.vue').then(m => m.default));
	Vue.component('create-post', () => import('./components/classwall/post/Create.vue').then(m => m.default));
	Vue.component('edit-post', () => import('./components/classwall/post/Edit.vue').then(m => m.default));
	Vue.component('show-post', () => import('./components/classwall/post/Show.vue').then(m => m.default));
	Vue.component('comment-list', () => import('./components/classwall/post/Comments.vue').then(m => m.default));
	Vue.component('emoji', () => import('./components/classwall/post/Emoji.vue').then(m => m.default));

//notification

Vue.component('notification-list', () => import('./components/notification/List.vue').then(m => m.default));
Vue.component('notification', () => import('./components/notification/Show.vue').then(m => m.default));

//School Detail
Vue.component('create-schooldetail', () => import('./components/schooldetail/Create.vue').then(m => m.default));
Vue.component('edit-schooldetail', () => import('./components/schooldetail/Edit.vue').then(m => m.default));

//student
Vue.component('member-list', () => import('./components/student/List.vue').then(m => m.default));
Vue.component('profile-tab', () => import('./components/student/profile/ProfileTab.vue').then(m => m.default));
Vue.component('search-filter', () => import('./components/student/Filter.vue').then(m => m.default));
Vue.component('create-member', () => import('./components/student/Create.vue').then(m => m.default));
Vue.component('edit-member', () => import('./components/student/Edit.vue').then(m => m.default));
Vue.component('create-medical-history', () => import('./components/student/CreateMedicalHistory.vue').then(m => m.default));

Vue.component('change-password-student', () => import('./components/student/ChangePassword.vue').then(m => m.default));

//Bulletin
Vue.component('create-bulletin', () => import('./components/bulletin/Create.vue').then(m => m.default));





//parent
Vue.component('parent-list', () => import('./components/parent/List.vue').then(m => m.default));
Vue.component('parent-search-filter', () => import('./components/parent/Filter.vue').then(m => m.default));
Vue.component('create-parent', () => import('./components/parent/Create.vue').then(m => m.default));
Vue.component('edit-parent', () => import('./components/parent/Edit.vue').then(m => m.default));
Vue.component('profile-tab-parent', () => import('./components/parent/profile/ProfileTab.vue').then(m => m.default));

//teacher
Vue.component('teacher-list', () => import('./components/teacher/List.vue').then(m => m.default));
Vue.component('teacher-filter', () => import('./components/teacher/Filter.vue').then(m => m.default));
Vue.component('create-teacher', () => import('./components/teacher/Create.vue').then(m => m.default));
Vue.component('profile-tab-teacher', () => import('./components/teacher/profile/ProfileTab.vue').then(m => m.default));
Vue.component('edit-teacher', () => import('./components/teacher/Edit.vue').then(m => m.default));
Vue.component('address-tab', () => import('./components/teacher/Address.vue').then(m => m.default));
Vue.component('notes-tab', () => import('./components/teacher/Notes.vue').then(m => m.default));
Vue.component('add-tab-teacher', () => import('./components/teacher/addTab.vue').then(m => m.default));

Vue.component('change-password-teacher', () => import('./components/teacher/ChangePassword.vue').then(m => m.default));
Vue.component('change-avatar-teacher', () => import('./components/teacher/ChangeAvatar.vue').then(m => m.default));

//Staff
Vue.component('staff-list', () => import('./components/staff/List.vue').then(m => m.default));
Vue.component('staff-filter', () => import('./components/staff/Filter.vue').then(m => m.default));

//promotion
Vue.component('create-promotion', () => import('./components/promotion/Create.vue').then(m => m.default));

//attendance
Vue.component('create-attendance', () => import('./components/attendance/Create.vue').then(m => m.default));
Vue.component('create-staff-attendance', () => import('./components/attendance/staff/Create.vue').then(m => m.default));



//discipline
Vue.component('create-discipline', () => import('./components/discipline/Create.vue').then(m => m.default));
Vue.component('edit-discipline', () => import('./components/discipline/Edit.vue').then(m => m.default));

//academic
Vue.component('standard-setup', () => import('./components/settings/StandardSetup.vue').then(m => m.default));
Vue.component('class-tab', () => import('./components/academic/class/classTab.vue').then(m => m.default));
Vue.component('create-class', () => import('./components/academic/Create1.vue').then(m => m.default));
Vue.component('edit-class', () => import('./components/academic/Edit.vue').then(m => m.default));
Vue.component('standardfilter', () => import('./components/academic/Filter.vue').then(m => m.default));

//academic year
Vue.component('list-academic-year', () => import('./components/academicyear/List.vue').then(m => m.default));
Vue.component('create-academic-year', () => import('./components/academicyear/Create.vue').then(m => m.default));
Vue.component('edit-academic-year', () => import('./components/academicyear/Edit.vue').then(m => m.default));

//holiday
Vue.component('add-holiday', () => import('./components/academic/holiday/Create.vue').then(m => m.default));
Vue.component('holiday-list', () => import('./components/academic/holiday/List.vue').then(m => m.default));

//subject
Vue.component('add-subjects', () => import('./components/subject/Create.vue').then(m => m.default));
Vue.component('edit-subjects', () => import('./components/subject/Edit.vue').then(m => m.default));



//Homework
Vue.component('create-homework', () => import('./components/homework/Create.vue').then(m => m.default));
Vue.component('edit-homework', () => import('./components/homework/Edit.vue').then(m => m.default));
Vue.component('show-homework', () => import('./components/homework/Show.vue').then(m => m.default));
Vue.component('home-work-list', () => import('./components/homework/List.vue').then(m => m.default));
Vue.component('list-tab-homework', () => import('./components/homework/approvedhomework/listTab.vue').then(m => m.default));

//Notice Board
Vue.component('create-circular', () => import('./components/noticeboard/Create.vue').then(m => m.default));
Vue.component('edit-circular', () => import('./components/noticeboard/Edit.vue').then(m => m.default));
Vue.component('notice-board-list', () => import('./components/noticeboard/List.vue').then(m => m.default));






//assignment-teacher
Vue.component('create-assignment', () => import('./components/assignment/teacher/Create.vue').then(m => m.default));
Vue.component('edit-assignment', () => import('./components/assignment/teacher/Edit.vue').then(m => m.default));
Vue.component('student-assignment-list', () => import('./components/assignment/teacher/StudentAssignmentList.vue').then(m => m.default));

//assignment
Vue.component('assignment-list', () => import('./components/assignment/List.vue').then(m => m.default));
Vue.component('list-tab-assignment', () => import('./components/assignment/approvedassignment/listTab.vue').then(m => m.default));

//student assignment
Vue.component('assignment-list-student', () => import('./components/assignment/student/List.vue').then(m => m.default));
Vue.component('attachment-assignment', () => import('./components/assignment/student/Attachment.vue').then(m => m.default));


//student homework
Vue.component('homework-list', () => import('./components/homework/student/List.vue').then(m => m.default));
Vue.component('attachment-homework', () => import('./components/homework/student/Attachment.vue').then(m => m.default));

//lesson-plan
Vue.component('lesson-plan-list', () => import('./components/lessonplan/List.vue').then(m => m.default));
Vue.component('approve-lesson-plan', () => import('./components/lessonplan/Approve.vue').then(m => m.default));
Vue.component('list-tab-lesson', () => import('./components/lessonplan/listTab.vue').then(m => m.default));
Vue.component('add-tab-lesson', () => import('./components/lessonplan/addTab.vue').then(m => m.default));


//leave application
Vue.component('leave-teacher-list', () => import('./components/leave/teacher/List.vue').then(m => m.default));
Vue.component('create-leave', () => import('./components/leave/teacher/Create.vue').then(m => m.default));
Vue.component('edit-leave', () => import('./components/leave/teacher/Edit.vue').then(m => m.default));
Vue.component('approve-leave', () => import('./components/leave/teacher/Approve.vue').then(m => m.default));
Vue.component('pending-count', () => import('./components/leave/teacher/PendingCount.vue').then(m => m.default));

//student leave application
Vue.component('student-leave-tab', () => import('./components/leave/student/listTab.vue').then(m => m.default));
Vue.component('student-leave-list', () => import('./components/leave/student/List.vue').then(m => m.default));
Vue.component('approve-student-leave', () => import('./components/leave/student/Approve.vue').then(m => m.default));

//reception leave application
Vue.component('reception-leave-list', () => import('./components/leave/reception/List.vue').then(m => m.default));
Vue.component('reception-create-leave', () => import('./components/leave/reception/Create.vue').then(m => m.default));
Vue.component('reception-edit-leave', () => import('./components/leave/reception/Edit.vue').then(m => m.default));

//absentees
Vue.component('absentees-student', () => import('./components/dashboard/StudentAttendance.vue').then(m => m.default));
Vue.component('absentees-staff', () => import('./components/dashboard/StaffAttendance.vue').then(m => m.default));

//visitor Log
Vue.component('add-visitor-log', () => import('./components/visitorlog/Create.vue').then(m => m.default));
Vue.component('list-visitor-log', () => import('./components/visitorlog/List.vue').then(m => m.default));
Vue.component('edit-visitor-log', () => import('./components/visitorlog/Edit.vue').then(m => m.default));

//call Log
Vue.component('add-call-log', () => import('./components/calllog/Create.vue').then(m => m.default));
Vue.component('list-call-log', () => import('./components/calllog/List.vue').then(m => m.default));
Vue.component('edit-call-log', () => import('./components/calllog/Edit.vue').then(m => m.default));


//postal Log
Vue.component('add-postal-record', () => import('./components/postalrecord/Create.vue').then(m => m.default));
Vue.component('list-postal-record', () => import('./components/postalrecord/List.vue').then(m => m.default));
Vue.component('edit-postal-record', () => import('./components/postalrecord/Edit.vue').then(m => m.default));

//visitor Log
Vue.component('add-teacher-visitor-log', () => import('./components/teacher/visitorlog/Create.vue').then(m => m.default));
Vue.component('list-teacher-visitor-log', () => import('./components/teacher/visitorlog/List.vue').then(m => m.default));
Vue.component('edit-teacher-visitor-log', () => import('./components/teacher/visitorlog/Edit.vue').then(m => m.default));

//call Log
Vue.component('add-teacher-call-log', () => import('./components/teacher/calllog/Create.vue').then(m => m.default));
Vue.component('list-teacher-call-log', () => import('./components/teacher/calllog/List.vue').then(m => m.default));
Vue.component('edit-teacher-call-log', () => import('./components/teacher/calllog/Edit.vue').then(m => m.default));


//postal Log
Vue.component('add-teacher-postal-record', () => import('./components/teacher/postalrecord/Create.vue').then(m => m.default));
Vue.component('list-teacher-postal-record', () => import('./components/teacher/postalrecord/List.vue').then(m => m.default));
Vue.component('edit-teacher-postal-record', () => import('./components/teacher/postalrecord/Edit.vue').then(m => m.default));




//dashboard
Vue.component('birthday', () => import('./components/dashboard/Birthday.vue').then(m => m.default));
Vue.component('view-birthday', () => import('./components/dashboard/ViewBirthday.vue').then(m => m.default));
Vue.component('birthday-teacher', () => import('./components/dashboard/BirthdayTeacher.vue').then(m => m.default));
Vue.component('view-birthday-teacher', () => import('./components/dashboard/ViewBirthdayTeacher.vue').then(m => m.default));
Vue.component('work-anniversary', () => import('./components/dashboard/WorkAnniversary.vue').then(m => m.default));
Vue.component('view-work-anniversary', () => import('./components/dashboard/ViewWorkAnniversary.vue').then(m => m.default));
Vue.component('dashboard-timetable-teacher', () => import('./components/dashboard/Timetable.vue').then(m => m.default));

//Event
Vue.component('create-event', () => import('./components/event/Create.vue').then(m => m.default));
Vue.component('edit-event', () => import('./components/event/Edit.vue').then(m => m.default));
Vue.component('show-event', () => import('./components/event/show.vue').then(m => m.default));
Vue.component('event-popup', () => import('./components/event/Popup.vue').then(m => m.default));
Vue.component('event-tab', () => import('./components/event/details/EventTab.vue').then(m => m.default));

//Edit Userprofile
Vue.component('edit-profile', () => import('./components/admin/EditProfile.vue').then(m => m.default));
Vue.component('change-password', () => import('./components/admin/ChangePassword.vue').then(m => m.default));
Vue.component('change-avatar', () => import('./components/admin/ChangeAvatar.vue').then(m => m.default));
Vue.component('change-credential', () => import('./components/admin/ChangeCredential.vue').then(m => m.default));

Vue.component('showimage', () => import('./components/event/details/ShowImage.vue').then(m => m.default));
//Vue.component('galleryimage', () => import('./components/event/details/GalleryImage.vue').then(m => m.default));

//Contact
Vue.component('contact', () => import('./components/contact.vue').then(m => m.default));

Vue.component('event', () => import('./components/dashboard/Event.vue').then(m => m.default));

//library


//custom-export
Vue.component('student-export', () => import('./components/export/Student.vue').then(m => m.default));
Vue.component('teacher-export', () => import('./components/export/Teacher.vue').then(m => m.default));
Vue.component('staff-export', () => import('./components/export/Staff.vue').then(m => m.default));

//books
Vue.component('add-book', () => import('./components/book/Create.vue').then(m => m.default));
Vue.component('edit-book', () => import('./components/book/Edit.vue').then(m => m.default));
Vue.component('edit-bookcategory', () => import('./components/bookcategory/Edit.vue').then(m => m.default));

//telephone directory
Vue.component('add-phone-number', () => import('./components/telephonedirectory/Create.vue').then(m => m.default));
Vue.component('edit-phone-number', () => import('./components/telephonedirectory/Edit.vue').then(m => m.default));
Vue.component('list-phone-number', () => import('./components/telephonedirectory/List.vue').then(m => m.default));



//Payroll
Vue.component('payroll-template', () => import('./components/accountant/payroll/template/List.vue').then(m => m.default));
Vue.component('create-template', () => import('./components/accountant/payroll/template/Create.vue').then(m => m.default));
Vue.component('edit-template', () => import('./components/accountant/payroll/template/Edit.vue').then(m => m.default));
Vue.component('payroll-salary', () => import('./components/accountant/payroll/salary/List.vue').then(m => m.default));
Vue.component('create-salary', () => import('./components/accountant/payroll/salary/Create.vue').then(m => m.default));
Vue.component('edit-salary', () => import('./components/accountant/payroll/salary/Edit.vue').then(m => m.default));
Vue.component('payroll-list', () => import('./components/accountant/payroll/payslip/List.vue').then(m => m.default));
Vue.component('create-payroll', () => import('./components/accountant/payroll/payslip/Create.vue').then(m => m.default));
Vue.component('edit-payroll', () => import('./components/accountant/payroll/payslip/Edit.vue').then(m => m.default));
Vue.component('transaction-list', () => import('./components/accountant/payroll/transaction/List.vue').then(m => m.default));
Vue.component('create-transaction', () => import('./components/accountant/payroll/transaction/Create.vue').then(m => m.default));
Vue.component('edit-transaction', () => import('./components/accountant/payroll/transaction/Edit.vue').then(m => m.default));

Vue.component('teacher-payroll-list', () => import('./components/payroll/teacher/payslip/List.vue').then(m => m.default));
Vue.component('teacher-transaction-list', () => import('./components/payroll/teacher/transaction/List.vue').then(m => m.default));
Vue.component('payroll-search-filter', () => import('./components/accountant/PayrollFilter.vue').then(m => m.default));

//Emergency Message

Vue.component('emergency-message', () => import('./components/emergency/Create.vue').then(m => m.default));

//booklending
Vue.component('add-booklending', () => import('./components/booklending/Create.vue').then(m => m.default));
Vue.component('edit-booklending', () => import('./components/booklending/Edit.vue').then(m => m.default));

//student library avtivity
Vue.component('list-lentbook', () => import('./components/booklending/List.vue').then(m => m.default));

//to do list
Vue.component('create-todo', () => import('./components/todolist/Create.vue').then(m => m.default));
Vue.component('edit-todo', () => import('./components/todolist/Edit.vue').then(m => m.default));
Vue.component('list-todo', () => import('./components/todolist/List.vue').then(m => m.default));

//dashboard to do 
Vue.component('list-task-tab', () => import('./components/todolist/listTab.vue').then(m => m.default));
Vue.component('dashboard-task', () => import('./components/dashboard/Task.vue').then(m => m.default));

//student task
Vue.component('add-student-task', () => import('./components/studenttask/List.vue').then(m => m.default));
Vue.component('add-student-task-popup', () => import('./components/studenttask/Create.vue').then(m => m.default));


//report
Vue.component('stock-search-filter', () => import('./components/report/StockFilter.vue').then(m => m.default));


//feed
Vue.component('add-post', () => import('./components/feed/Create.vue').then(m => m.default));
Vue.component('show-feed', () => import('./components/feed/ShowFeed.vue').then(m => m.default));
Vue.component('slider-image', () => import('./components/feed/slider.vue').then(m => m.default));


// home slider
Vue.component('homeslider', () => import('./components/Slider.vue').then(m => m.default));
Vue.component('nav-bar', () => import('./components/Navigation.vue').then(m => m.default));

//new

Vue.component('teacherlist-lentbook', () => import('./components/booklending/TeacherList.vue').then(m => m.default));

//Library cards 
Vue.component('librarymembersearch-filter', () => import('./components/librarycard/Filter.vue').then(m => m.default));
Vue.component('librarymember-list', () => import('./components/librarycard/List.vue').then(m => m.default));
Vue.component('libraryteachersearch-filter', () => import('./components/librarycard/TeacherFilter.vue').then(m => m.default));
Vue.component('libraryteacher-list', () => import('./components/librarycard/TeacherList.vue').then(m => m.default));
Vue.component('librarystaff-list', () => import('./components/librarycard/StaffList.vue').then(m => m.default));
Vue.component('librarystaff-filter', () => import('./components/librarycard/StaffFilter.vue').then(m => m.default));



export const bus = new Vue();
import VueSwal from 'vue-swal';
Vue.use(VueSwal);

const app = new Vue({
    el: '#app'
});

import Paginate from 'vuejs-paginate'
Vue.component('paginate', Paginate);