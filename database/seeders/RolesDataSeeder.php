<?php

namespace Database\Seeders;

use App\Models\Ability;
use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RolesDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    protected $ability =[
       'all_admins' => 'All Admins',
       'add_admin' => 'Add Admin',
       'delete_admin' => 'Delete Admin',
       'all_universities' => 'All Universities',
       'add_university' => 'Add University',
       'delete_university' => 'Delete University',
       'edit_university' => 'Edit University',
       'all_specializations' => 'All Specializations',
       'add_specialization' => 'Add Specialization',
       'delete_specialization' => 'Delete Specialization',
       'edit_specialization' => 'Edit Specialization',
       'all_teachers' => 'All Teachers',
       'add_teacher' => 'Add Teacher',
       'delete_teacher' => 'Delete Teacher',
       'all_programs' => 'All Programs',
       'add_program' => 'Add Programs',
       'edit_program' => 'Edit Programs',
       'delete_program' => 'Delete Programs',
       'recycle_programs' => 'Recycle Bin Programs',
       'restore_program' => 'Restore Program',
       'forceDelete_program' => 'Force Delete Program',
       'all_companies' => 'All Companies',
       'add_company' => 'Add Company',
       'delete_company' => 'Delete Company',
       'edit_company' => 'Edit Company',
       'recycle_companies' => 'Recycle Bin Companies',
       'restore_company' => 'Restore Company',
       'forceDelete_company' => 'Force Delete Company',
       'all_trainers' => 'All Trainers',
       'add_trainer' => 'Add Trainer',
       'delete_trainer' => 'Delete Trainer',
       'all_evaluations' => 'All Evaluations',
       'add_evaluation' => 'Add Evaluation',
       'edit_evaluation' => 'Edit Evaluation',
       'delete_evaluation' => 'Delete Evaluation',
       'all_adverts' => 'All Adverts',
       'add_advert' => 'Add Advert',
       'edit_advert' => 'Edit Advert',
       'delete_advert' => 'Delete Advert',
       'all_students' => 'All Students',
       'delete_student' => 'Delete Student',
       'evaluate_student' => 'Evaluate Student',
       'evaluation_student' => 'Evaluation Student',
       'more_about_student' => 'More About Student',
       'student_attendence' => 'Student Attendence',
       'recycle_students' => 'Recycle Bin Student',
       'restore_student' => 'Restore Student',
       'forceDelete_student' => 'Force Delete Student',
       'all_university_ids' => 'All University IDs',
       'add_university_id' => 'Add University ID',
       'edit_university_id' => 'Edit University ID',
       'delete_university_id' => 'Delete University ID',
       'import_university_id' => 'Import University ID',
       'all_tasks' => 'All Tasks',
       'add_task' => 'Add Task',
       'edit_task' => 'Edit Task',
       'delete_task' => 'Delete Task',
       'all_roles' => 'All Roles',
       'add_role' => 'Add Role',
       'edit_role' => 'Edit Role',
       'delete_role' => 'Delete Role',
       'settings' => 'Settings',
       'notification' => 'Notifications',
       'messages' => 'Messages',
       'attendance' => 'Attendances',

    ];
    public function run()
    {
        $data = [
            ['name' => 'Super Admin'] ,
            ['name' => 'Sub Admin'] ,
            ['name' => 'Teacher'] ,
            ['name' => 'Company'] ,
            ['name' => 'Trainer'] ,
        ];
        Role::insert($data);

        foreach($this->ability as $code=>$name){
            Ability::create([
                'name'=>$name,
                'code' => $code
            ]);
        }
    }
}
