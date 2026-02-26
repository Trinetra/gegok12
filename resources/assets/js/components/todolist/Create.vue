<template>
    <div class="bg-white shadow px-4 py-3">
        <div v-if="this.success!=null" class="alert alert-success mt-2" id="success-alert">{{ this.success }}</div>

        <div class="my-5" v-if="this.hidecolumns == 'false'">
            <div class="tw-form-group w-full lg:w-3/4 md:w-3/4">
                <div class="lg:mr-8 md:mr-8 flex flex-col lg:flex-row md:flex-row lg:items-center w-full">
                    <div class="mb-2 w-full lg:w-1/4 md:w-1/4">
                        <label for="assignee" class="tw-form-label">Assign To<span class="text-red-500">*</span></label>
                    </div>
                    <div class="mb-2 w-full lg:w-1/2 md:w-1/2">
                        <select name="assignee" id="assignee" v-model="assignee" class="tw-form-control w-full" v-on:change="selectAssignee()">
                            <option value="" disabled>Select Assign To</option>
                            <option v-for="list in assignlist" v-bind:value="list.id">{{ list.name }}</option>
                        </select>
                        <span v-if="errors.assignee" class="text-red-500 text-xs font-semibold">{{ errors.assignee[0] }}</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="hidden" id="student_list">
            <div class="my-5">
                <div class="tw-form-group w-full lg:w-3/4 md:w-3/4">
                    <div class="lg:mr-8 md:mr-8 flex flex-col lg:flex-row md:flex-row lg:items-center w-full">
                        <div class="mb-2 w-full lg:w-1/4 md:w-1/4">
                            <label for="standardLink_id" class="tw-form-label">Class<span class="text-red-500">*</span></label>
                        </div>
                        <div class="mb-2 w-full lg:w-1/2 md:w-1/2" v-if="this.assignee == 'class'">
                            <select name="standardLink_id" id="standardLink_id" v-model="standardLink_id" class="tw-form-control w-full">
                                <option value="" disabled>Select Class</option>
                                <option v-for="standardLink in standardLinklist" v-bind:value="standardLink.id">{{ standardLink.standard_section }}</option>
                            </select>
                            <span v-if="errors.standardLink_id" class="text-red-500 text-xs font-semibold">{{errors.standardLink_id[0]}}</span>
                        </div>
                        <div class="mb-2 w-full lg:w-1/2 md:w-1/2" v-else-if="this.assignee == 'student'">
                            <select name="standardLink_id" id="standardLink_id" v-model="standardLink_id" class="tw-form-control w-full" v-on:change="enableStudent">
                                <option value="" disabled>Select Class</option>
                                <option v-for="standardLink in standardLinklist" v-bind:value="standardLink.id">{{ standardLink.standard_section }}</option>
                            </select>
                            <span v-if="errors.standardLink_id" class="text-red-500 text-xs font-semibold">{{ errors.standardLink_id[0] }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="my-5" v-if="this.standardLink_id != '' && this.assignee == 'student'">
                <div class="w-full flex flex-wrap items-center justify-between mb-4">
                    <div class="flex items-center text-sm" v-if="Object.keys(this.studentlist).length > 0">
                        <div class="px-3 border-r">
                            {{ parseInt(this.selectedUsersCount) }} students selected
                        </div>
                        <div class="px-3 border-r relative">
                            <input class="opacity-0 absolute w-full h-full cursor-pointer" type="checkbox" @click="selectAll($event,'student')" v-model="allSelected"><span>Select All</span>
                        </div>
                        <div class="px-3 relative" v-if="this.selectedUsersCount > 0">
                            <input class="opacity-0 absolute w-full h-full cursor-pointer" type="checkbox" @click="selectNone($event,'student')" v-model="noneSelected"><span>Select None</span>
                        </div>
                    </div> 
                </div>
                <div class="flex flex-wrap" v-if="Object.keys(this.studentlist).length > 0">
                    <div class="w-full lg:w-1/4 md:w-1/2 my-2 relative" v-for="user in studentlist">
                        <div class="flex justify-between member-list">
                            <div class="flex items-center student_select">
                                <input class="w-5 h-5" type="checkbox" v-model="selected" :value="user['id']" @click="selectedCount(user['id'],$event,'student')">
                                <label></label>
                            </div>
                            <div 
                              class="flex p-2 w-full"
                              :class="selected.includes(user.id) ? 'student_selected' : ''"
                            >
                                <div class="px-2">
                                    <h2 class="font-bold text-base text-gray-700">{{ user['name'] }}</h2>
                                    <p>{{ user['class'] }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="flex flex-wrap" v-else>
                    <div class="w-full">
                        <div class="flex justify-between">
                            <p style="text-align: center;">No Students Found</p>
                        </div>
                    </div>
                </div>
                <span v-if="errors.selectedUsersCount" class="text-red-500 text-xs font-semibold">{{ errors.selectedUsersCount[0] }}</span>
            </div>
        </div>

        <div class="hidden" id="teacher_list">
            <div class="my-5">
                <div class="tw-form-group w-full lg:w-3/4 md:w-3/4">
                    <div class="lg:mr-8 md:mr-8 flex flex-col lg:flex-row mf:flex-row lg:items-center w-full">
                        <div class="mb-2 w-full lg:w-1/4 md:w-1/4">
                            <label for="standardLink_id" class="tw-form-label">Teacher<span class="text-red-500">*</span></label>
                        </div>
                    </div>
                </div>
            </div>

            <div class="my-5">
                <div class="w-full flex flex-wrap items-center justify-between mb-4">
                    <div class="flex items-center text-sm" v-if="Object.keys(this.teacherlist).length > 0">
                        <div class="px-3 border-r">
                            {{ parseInt(this.selectedTeachersCount) }} teachers selected
                        </div>
                        <div class="px-3 border-r relative">
                            <input class="opacity-0 absolute w-full h-full cursor-pointer" type="checkbox" @click="selectAll($event,'teacher')" v-model="allSelectedTeacher"><span>Select All</span>
                        </div>
                        <div class="px-3 relative" v-if="this.selectedTeachersCount > 0">
                            <input class="opacity-0 absolute w-full h-full cursor-pointer" type="checkbox" @click="selectNone($event,'teacher')" v-model="noneSelectedTeacher"><span>Select None</span>
                        </div>
                    </div> 
                </div>
                <div class="flex flex-wrap" v-if="Object.keys(this.teacherlist).length > 0">
                    <div class="w-full lg:w-1/4 md:w-1/2 my-2 relative" v-for="user in teacherlist">
                        <div class="flex justify-between member-list">
                            <div class="flex items-center student_select">
                                <input class="w-5 h-5" type="checkbox" v-model="teachers" :value="user['id']" @click="selectedCount(user['id'],$event,'teacher')">
                                <label></label>
                            </div>
                            <div 
                              class="flex p-2 w-full"
                              :class="teachers.includes(user.id) ? 'student_selected' : ''"
                            >
                                <div class="px-2">
                                    <h2 class="font-bold text-base text-gray-700">{{ user.fullname }}</h2>
                                    <p>{{ user.designation }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="flex flex-wrap" v-else>
                    <div class="w-full">
                        <div class="flex justify-between">
                            <p style="text-align: center;">No Teachers Found</p>
                        </div>
                    </div>
                </div>
                <span v-if="errors.selectedTeachersCount" class="text-red-500 text-xs font-semibold">{{ errors.selectedTeachersCount[0] }}</span>
            </div>
        </div>

        <div class="my-5">
            <div class="tw-form-group w-full lg:w-3/4 md:w-3/4">
                <div class="lg:mr-8 md:mr-8 flex flex-col lg:flex-row md:flex-row lg:items-center w-full">
                    <div class="mb-2 w-full lg:w-1/4 md:w-1/4">
                        <label for="title" class="tw-form-label">Title<span class="text-red-500">*</span></label>
                    </div>
                    <div class="mb-2 w-full lg:w-1/2 md:w-1/2">
                        <input type="text" name="title" v-model="title" class="tw-form-control w-full" placeholder="Title"><br>
                        <span v-if="errors.title" class="text-red-500 text-xs font-semibold">{{ errors.title[0] }}</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="my-5">
            <div class="tw-form-group w-full lg:w-3/4 md:w-3/4">
                <div class="lg:mr-8 md:mr-8 flex flex-col lg:flex-row md:flex-row lg:items-center w-full">
                    <div class="mb-2 w-full lg:w-1/4 md:w-1/4">
                        <label for="to_do_list" class="tw-form-label">Description<span class="text-red-500">*</span></label>
                    </div>
                    <div class="mb-2 w-full lg:w-1/2 md:w-1/2">
                        <textarea type="text" name="to_do_list" v-model="to_do_list" class="tw-form-control w-full" placeholder="Description"></textarea><br>
                        <span v-if="errors.to_do_list" class="text-red-500 text-xs font-semibold">{{ errors.to_do_list[0] }}</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="my-5">
            <div class="tw-form-group w-full lg:w-3/4 md:w-3/4">
                <div class="lg:mr-8 md:mr-8 flex flex-col lg:flex-row md:flex-row lg:items-center w-full">
                    <div class="mb-2 w-full lg:w-1/4 md:w-1/4">
                        <label for="task_date" class="tw-form-label">Date<span class="text-red-500">*</span></label>
                    </div>
                    <div class="mb-2 w-full lg:w-1/2 md:w-1/2 relative">
                    <div class="flex items-center">
                        <VueDatePicker
                          v-model="task_date"
                          format="dd-MM-yyyy HH:mm:ss"
                          model-type="format"
                          :enable-time-picker="true"
                          :is-24="true"
                          :auto-apply="true"
                          input-class-name="w-full rounded"
                        />
                    </div>
                     <span v-if="errors.task_date" class="text-red-500 text-xs font-semibold">{{ errors.task_date[0] }}</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="my-5">
            <div class="tw-form-group w-full lg:w-3/4 md:w-3/4">
                <div class="lg:mr-8 md:mr-8 flex flex-col lg:flex-row md:flex-row lg:items-center w-full">
                    <div class="mb-2 w-full lg:w-1/4 md:w-1/4">
                        <label for="reminder" class="tw-form-label">Reminder<span class="text-red-500">*</span></label>
                    </div>
                    <div class="mb-2 w-full lg:w-1/2 md:w-1/2">
                        <select name="reminder" id="reminder" v-model="reminder" class="tw-form-control w-full" v-on:change="selectAssignee()">
                            <option value="" disabled>Select Reminder</option>
                            <option v-for="list in reminderlist" v-bind:value="list.id">{{ list.name }}</option>
                        </select>
                        <span v-if="errors.reminder" class="text-red-500 text-xs font-semibold">{{ errors.reminder[0] }}</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="my-5" v-if="this.reminder == 'others'">
            <div class="tw-form-group w-full lg:w-3/4 md:w-3/4">
                <div class="lg:mr-8 md:mr-8 flex flex-col lg:flex-row md:flex-row lg:items-center w-full">
                    <div class="mb-2 w-full lg:w-1/4 md:w-1/4">
                        <label for="reminder_date" class="tw-form-label">Reminder Date<span class="text-red-500">*</span></label>
                    </div>
                    <div class="mb-2 w-full lg:w-1/2 md:w-1/2 relative">
                        <div class="flex items-center">
                            <VueDatePicker
                              v-model="reminder_date"
                              format="dd-MM-yyyy HH:mm:ss"
                              model-type="format"
                              :enable-time-picker="true"
                              :is-24="true"
                              :auto-apply="true"
                              input-class-name="w-full rounded"
                            />
                        </div>
                        <span v-if="errors.reminder_date" class="text-red-500 text-xs font-semibold">{{ errors.reminder_date[0] }}</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="my-6">
            <a href="#" id="submit-btn" class="btn btn-submit blue-bg text-white rounded px-3 py-1 mr-3 text-sm font-medium" @click="submitForm()">Submit</a>
            <a href="#" class="btn btn-reset bg-gray-100 text-gray-700 border rounded px-3 py-1 mr-3 text-sm font-medium" @click="resetForm()">Reset</a>    
        </div>
    </div>
</template>

<script>
    import { VueDatePicker } from '@vuepic/vue-datepicker'
    import '@vuepic/vue-datepicker/dist/main.css'
    export default {
        props:['url','searchquery','mode','hidecolumns'],
        components:{ VueDatePicker },
        data () {
            return {
                tasks:[],
                edit:[],
                assignee:'self',
                reminder:'',
                title:'',
                standardLink_id:'',
                reminder_date:'',
                selected: [],
                selectedUsers:[],
                allSelected: false,
                noneSelected:false,
                selectedTeachers:[],
                allSelectedTeacher: false,
                noneSelectedTeacher:false,
                teachers:[],
                to_do_list:'',
                task_date:'',
                edittask:'',
                show:0,
                editshow:0,
                assignlist:[ { id : 'class' , name : 'Class' } , { id : 'self' , name : 'Self' } , { id : 'student' , name : 'Student' } , { id : 'teacher' , name : 'Teachers' }],
                reminderlist:[ { id : 'one_hour_before_the_task' , name : 'One Hour Before The Task' } , { id : 'one_day_before_the_task' , name : 'One Day Before The Task' } , { id : 'two_days_before_the_task' , name : 'Two Days Before The Task' } , { id : 'others' , name : 'Select Date' } ],
                isLoading: false,
                standardLinklist:[],
                studentlist:[],
                teacherlist:[],
                param:{},
                errors:[],
                success:null,
            }
        },

        computed: {
            selectedUsersCount() {
                return this.selected.length;
            },
            selectedTeachersCount() {
                return this.teachers.length;
            }
        },

        methods:
        {
            getData(url,query)
            {
                axios.get(url+'?'+query).then(response => {
                    this.tasks = response.data;
                    this.setData();
                    //console.log(this.tasks);    
                });
            },

            setData(query)
            {
                if(Object.keys(this.tasks).length > 0)
                {
                    this.standardLinklist   = this.tasks.standardlinks;
                    this.studentlist        = this.tasks.students;
                    this.teacherlist        = this.tasks.teachers;
                    this.task_date          = this.tasks.task_date;
                    this.isLoading          = false;
                }
            },

            selectAssignee()
            {
                if(this.assignee == 'class')
                {
                    if($('#student_list').hasClass('hidden'))
                    {
                        $('#student_list').removeClass('hidden').addClass('block');
                        $('#teacher_list').removeClass('block').addClass('hidden');
                    }
                }
                else if(this.assignee == 'student')
                {
                    if($('#student_list').hasClass('hidden'))
                    {
                        $('#student_list').removeClass('hidden').addClass('block');
                        $('#teacher_list').removeClass('block').addClass('hidden');
                    }
                }
                else if(this.assignee == 'teacher')
                {
                    if($('#teacher_list').hasClass('hidden'))
                    {
                        $('#teacher_list').addClass('block').removeClass('hidden');
                        $('#student_list').addClass('hidden').removeClass('block');
                    }
                }
                else
                {
                    $('#teacher_list').addClass('hidden').removeClass('block');
                    $('#student_list').addClass('hidden').removeClass('block');
                }
            },

            enableStudent()
            {
                this.params = { standardlink_id:this.standardLink_id };
                this.final = this.url+'/'+this.mode+'/task/add/list';

                Object.keys(this.params).forEach(key => {
                    this.final = this.addParam(this.final, key, this.params[key])
                });

                this.getData(this.final);

                if($('#student').hasClass('hidden'))
                {
                    $('#student').addClass('block').removeClass('hidden');
                }
            },

            addParam(url, param, value) 
            {
                param = encodeURIComponent(param);
                var r = "([&?]|&amp;)" + param + "\\b(?:=(?:[^&#]*))*";
                var a = document.createElement('a');
                var regex = new RegExp(r);
                var str = param + (value ? "=" + encodeURIComponent(value) : ""); 
                a.href = url;
                var q = a.search.replace(regex, "$1"+str);
                if (q === a.search) 
                {
                    a.search += (a.search ? "&" : "") + str;
                } 
                else 
                {
                    a.search = q;
                }
                return a.href ;
            },

            selectAll(e, type) {
                if (type === 'student') {
                    if (e.target.checked) {
                        this.selected = this.studentlist.map(user => user.id);
                        this.selectedUsers = [...this.selected];
                    } else {
                        this.selected = [];
                        this.selectedUsers = [];
                    }
                }

                if (type === 'teacher') {
                    if (e.target.checked) {
                        this.teachers = this.teacherlist.map(user => user.id);
                        this.selectedTeachers = [...this.teachers];
                    } else {
                        this.teachers = [];
                        this.selectedTeachers = [];
                    }
                }
            },
            selectNone(e, type) {
                if (e.target.checked) {
                    if (type === 'student') {
                        this.selected = [];
                        this.selectedUsers = [];
                    }

                    if (type === 'teacher') {
                        this.teachers = [];
                        this.selectedTeachers = [];
                    }
                }
            },

            selectedCount(id, e, type) {
                if (type === 'student') {
                    this.selectedUsers = [...this.selected];
                }

                if (type === 'teacher') {
                    this.selectedTeachers = [...this.teachers];
                }
            },

            removeUser(item, arr)
            {
                for (var i=0 ; i < arr.length ; i++)
                {
                    if (arr[i]==item)
                    {
                        arr.splice(i,1); //this delete from the "i" index in the array to the "1" length
                        break;
                    }
                } 
            },

            submitForm()
            {
                this.errors = [];
                this.success = null;

                if(this.hidecolumns != 'false')
                {
                    this.assignee = 'self';
                }
                else
                {
                    this.assignee = this.assignee;
                }
                axios.post('/'+this.mode+'/task/add',{
                    assignee:this.assignee,
                    standardLink_id:this.standardLink_id,
                    selected:this.selected, 
                    selectedUsers:this.selected,
                    selectedUsersCount: this.selected.length,
                    teachers:this.teachers,
                    selectedTeachers: this.teachers,
                    selectedTeachersCount: this.teachers.length,
                    title:this.title,
                    to_do_list:this.to_do_list,
                    task_date:this.task_date,
                    reminder:this.reminder,
                    reminder_date:this.reminder_date,
                }).then(response => {
                    this.success = response.data.success;
                    this.resetForm();
                }).catch(error => {
                  this.errors = error.response.data.errors;
                });
            },

            resetForm()
            {
                window.location.reload();
            },
        },
        created()
        {   
            //
            this.getData('/'+this.mode+'/task/add/list');
        }
    }
</script>