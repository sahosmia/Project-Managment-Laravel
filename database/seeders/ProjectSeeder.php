<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class ProjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Disable foreign key checks for a moment to avoid issues during seeding
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        // Clear existing data (optional, but good for fresh seeds)
        DB::table('departments')->truncate();
        DB::table('r_cells')->truncate();
        DB::table('users')->truncate();
        DB::table('projects')->truncate();
        DB::table('project_members')->truncate();

        // 1. Seed Departments
        $departments = [
            ['name' => 'Computer Science and Engineering'],
            ['name' => 'Electrical and Electronic Engineering'],
            ['name' => 'Architecture and Design Studies'],
        ];
        DB::table('departments')->insert($departments);
        $cseDepartmentId = DB::table('departments')->where('name', 'Computer Science and Engineering')->first()->id;
        $eeeDepartmentId = DB::table('departments')->where('name', 'Electrical and Electronic Engineering')->first()->id;
        $adsDepartmentId = DB::table('departments')->where('name', 'Architecture and Design Studies')->first()->id;


        // 2. Seed Research Cells (RCells)
        $rcellsData = [
            ['name' => 'AI Research Lab'],
            ['name' => 'Web Technologies Group'],
            ['name' => 'Cybersecurity Center'],
            ['name' => 'Robotics & Automation Lab'],
        ];
        DB::table('r_cells')->insert($rcellsData);
        $aiRcellId = DB::table('r_cells')->where('name', 'AI Research Lab')->first()->id;
        $webRcellId = DB::table('r_cells')->where('name', 'Web Technologies Group')->first()->id;
        $cybersecurityRcellId = DB::table('r_cells')->where('name', 'Cybersecurity Center')->first()->id;


        // 3. Seed Users (Admins, Research Cells, Supervisors, Students)
        // Passwords are 'password'
        $adminUser = DB::table('users')->insertGetId([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'approved' => 1,
            'email_verified_at' => now(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $faculty1 = DB::table('users')->insertGetId([
            'name' => 'Dr. Full Name',
            'email' => 'full@example.com',
            'password' => Hash::make('password'),
            'role' => 'faculty_member',
                        'approved' => 1,

            'email_verified_at' => now(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $faculty2 = DB::table('users')->insertGetId([
            'name' => 'Dr. Manik',
            'email' => 'manik@example.com',
            'password' => Hash::make('password'),
            'role' => 'faculty_member',
                        'approved' => 1,

            'email_verified_at' => now(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $faculty3 = DB::table('users')->insertGetId([
            'name' => 'Dr. Abid',
            'email' => 'abid@example.com',
            'password' => Hash::make('password'),
            'role' => 'faculty_member',
            'email_verified_at' => now(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $student1 = DB::table('users')->insertGetId([
            'name' => 'Student One',
            'email' => 'student1@example.com',
            'password' => Hash::make('password'),
            'role' => 'student',
            'student_id' => 'S12345',
            'phone' => '01711111111',
                        'approved' => 1,

            'email_verified_at' => now(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $student2 = DB::table('users')->insertGetId([
            'name' => 'Student Two',
            'email' => 'student2@example.com',
            'password' => Hash::make('password'),
            'role' => 'student',
            'student_id' => 'S67890',
            'phone' => '01722222222',
            'email_verified_at' => now(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $student3 = DB::table('users')->insertGetId([
            'name' => 'Student Three',
            'email' => 'student3@example.com',
            'password' => Hash::make('password'),
            'role' => 'student',
            'student_id' => 'S11223',
            'phone' => '01733333333',
            'email_verified_at' => now(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $student4 = DB::table('users')->insertGetId([
            'name' => 'Student Four',
            'email' => 'student4@example.com',
            'password' => Hash::make('password'),
            'role' => 'student',
            'student_id' => 'S44556',
            'phone' => '01744444444',
            'email_verified_at' => now(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);


        // 4. Seed Projects
        DB::table('r_cells')->where('id', $aiRcellId)->update(['research_cell_head' => $faculty1]);
        DB::table('r_cells')->where('id', $webRcellId)->update(['research_cell_head' => $faculty2]);
        DB::table('r_cells')->where('id', $cybersecurityRcellId)->update(['research_cell_head' => $faculty3]);

        $projectId1 = DB::table('projects')->insertGetId([
            'title' => 'AI-Powered Chatbot for University Support',
            'academic_year' => '2024',
            'course_title' => 'Project & Thesis',
            'course_code' => 'CSE400',
            'problem_statement' => 'Students struggle to find information quickly.',
            'motivation' => 'To improve student support and reduce administrative burden.',
            'course_type' => 'project',
            'semester' => 'Fall',
            'status' => 'pending_research_cell',
            'created_by' => $student1,
            'department_id' => $cseDepartmentId,
            'r_cell_id' => $aiRcellId,
            'supervisor_id' => $faculty1,
            'cosupervisor_id' => $faculty2,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $projectId2 = DB::table('projects')->insertGetId([
            'title' => 'Web-Based E-commerce Platform',
            'academic_year' => '2023',
            'course_title' => 'Project & Thesis',
            'course_code' => 'CSE300',
            'problem_statement' => 'Small businesses lack affordable online presence.',
            'motivation' => 'To provide a cost-effective solution for local businesses.',
            'course_type' => 'project',
            'semester' => 'Summer',
            'status' => 'pending_admin',
            'created_by' => $student2,
            'department_id' => $cseDepartmentId,
            'r_cell_id' => $webRcellId,
            'supervisor_id' => $faculty2,
            'cosupervisor_id' => $faculty1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $projectId3 = DB::table('projects')->insertGetId([
            'title' => 'IoT Based Smart Home System',
            'academic_year' => '2025',
            'course_title' => 'Project & Thesis',
            'course_code' => 'EEE450',
            'problem_statement' => 'Lack of integrated home automation solutions.',
            'motivation' => 'To develop an intuitive and secure smart home system.',
            'course_type' => 'thesis',
            'semester' => 'Spring',
            'status' => 'pending_admin',
            'created_by' => $student1,
            'department_id' => $eeeDepartmentId,
            'r_cell_id' => null,
            'supervisor_id' => $faculty3,
            'cosupervisor_id' => $faculty2,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Additional Projects
        $projectId4 = DB::table('projects')->insertGetId([
            'title' => 'Cybersecurity Threat Detection System',
            'academic_year' => '2024',
            'course_title' => 'Project & Thesis',
            'course_code' => 'CSE410',
            'problem_statement' => 'Increasing cyber threats to organizational data.',
            'motivation' => 'To develop an intelligent system for early threat identification.',
            'course_type' => 'thesis',
            'semester' => 'Spring',
            'status' => 'rejected_research_cell',
            'created_by' => $student3,
            'department_id' => $cseDepartmentId,
            'r_cell_id' => $cybersecurityRcellId,
            'supervisor_id' => $faculty1,
            'cosupervisor_id' => $faculty2,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $projectId5 = DB::table('projects')->insertGetId([
            'title' => 'Mobile Application for Campus Navigation',
            'academic_year' => '2025',
            'course_title' => 'Project & Thesis',
            'course_code' => 'CSE420',
            'problem_statement' => 'Students find it difficult to navigate large campus areas.',
            'motivation' => 'To provide an easy-to-use navigation tool for students and visitors.',
            'course_type' => 'project',
            'semester' => 'Fall',
            'status' => 'pending_supervisor',
            'created_by' => $student4,
            'department_id' => $cseDepartmentId,
            'r_cell_id' => $webRcellId,
            'supervisor_id' => $faculty2,
            'cosupervisor_id' => null,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $projectId6 = DB::table('projects')->insertGetId([
            'title' => 'Automated Waste Segregation System',
            'academic_year' => '2023',
            'course_title' => 'Project & Thesis',
            'course_code' => 'EEE380',
            'problem_statement' => 'Inefficient manual waste sorting leads to environmental issues.',
            'motivation' => 'To contribute to sustainable waste management through automation.',
            'course_type' => 'project',
            'semester' => 'Summer',
            'status' => 'completed',
            'created_by' => $student1,
            'department_id' => $eeeDepartmentId,
            'r_cell_id' => null,
            'supervisor_id' => $faculty3,
            'cosupervisor_id' => $faculty1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);


        // 5. Seed Project Members
        DB::table('project_members')->insert([
            [
                'project_id' => $projectId1,
                'student_id' => $student1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'project_id' => $projectId1,
                'student_id' => $student2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'project_id' => $projectId2,
                'student_id' => $student2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'project_id' => $projectId2,
                'student_id' => $student1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'project_id' => $projectId3,
                'student_id' => $student1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // Additional project members for new projects
            [
                'project_id' => $projectId4,
                'student_id' => $student3,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'project_id' => $projectId4,
                'student_id' => $student4,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'project_id' => $projectId5,
                'student_id' => $student4,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'project_id' => $projectId6,
                'student_id' => $student1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'project_id' => $projectId6,
                'student_id' => $student3,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        // Re-enable foreign key checks
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
