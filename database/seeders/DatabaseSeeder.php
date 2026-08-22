<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Job;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Demo employer
        $employer = User::firstOrCreate(
            ['email' => 'employer@demo.com'],
            [
                'name' => 'Demo Employer',
                'password' => Hash::make('password'),
                'role' => 'employer',
                'email_verified_at' => now(),
            ]
        );

        // Categories
        $categories = collect([
            'Engineering', 'Design', 'Marketing', 'Sales', 'Customer Support', 'Operations',
        ])->mapWithKeys(function ($name) {
            $category = Category::firstOrCreate(
                ['slug' => \Illuminate\Support\Str::slug($name)],
                ['name' => $name]
            );
            return [$name => $category->id];
        });

        // Job listings
        $jobs = [
            ['title' => 'Senior Backend Engineer', 'category' => 'Engineering', 'location' => 'Remote', 'job_type' => 'full-time', 'remote_option' => 'remote', 'salary' => 95000, 'company_name' => 'Northwind Labs'],
            ['title' => 'Frontend Developer', 'category' => 'Engineering', 'location' => 'Cebu City, PH', 'job_type' => 'full-time', 'remote_option' => 'hybrid', 'salary' => 55000, 'company_name' => 'Brightpath Studio'],
            ['title' => 'Product Designer', 'category' => 'Design', 'location' => 'Remote', 'job_type' => 'contract', 'remote_option' => 'remote', 'salary' => 40000, 'company_name' => 'Fieldstone Co.'],
            ['title' => 'UI/UX Intern', 'category' => 'Design', 'location' => 'Manila, PH', 'job_type' => 'internship', 'remote_option' => 'on-site', 'salary' => null, 'company_name' => 'Halcyon Studio'],
            ['title' => 'Digital Marketing Specialist', 'category' => 'Marketing', 'location' => 'Remote', 'job_type' => 'part-time', 'remote_option' => 'remote', 'salary' => 25000, 'company_name' => 'Greenline Media'],
            ['title' => 'Content Strategist', 'category' => 'Marketing', 'location' => 'Davao City, PH', 'job_type' => 'full-time', 'remote_option' => 'hybrid', 'salary' => 38000, 'company_name' => 'Ledger & Co.'],
            ['title' => 'Sales Account Executive', 'category' => 'Sales', 'location' => 'Cebu City, PH', 'job_type' => 'full-time', 'remote_option' => 'on-site', 'salary' => 45000, 'company_name' => 'Everest Solutions'],
            ['title' => 'Customer Support Representative', 'category' => 'Customer Support', 'location' => 'Remote', 'job_type' => 'full-time', 'remote_option' => 'remote', 'salary' => 28000, 'company_name' => 'Anchorpoint Inc.'],
            ['title' => 'Operations Coordinator', 'category' => 'Operations', 'location' => 'Quezon City, PH', 'job_type' => 'full-time', 'remote_option' => 'hybrid', 'salary' => 32000, 'company_name' => 'Meridian Group'],
            ['title' => 'Junior Software Engineer', 'category' => 'Engineering', 'location' => 'Remote', 'job_type' => 'full-time', 'remote_option' => 'remote', 'salary' => 42000, 'company_name' => 'Northwind Labs'],
        ];

        foreach ($jobs as $job) {
            Job::firstOrCreate(
                ['title' => $job['title'], 'company_name' => $job['company_name']],
                [
                    'user_id' => $employer->id,
                    'category_id' => $categories[$job['category']],
                    'description' => "We're looking for a {$job['title']} to join our team. This role involves collaborating closely with a small, focused team on meaningful work.",
                    'location' => $job['location'],
                    'salary' => $job['salary'],
                    'job_type' => $job['job_type'],
                    'remote_option' => $job['remote_option'],
                    'company_name' => $job['company_name'],
                    'status' => 'open',
                ]
            );
        }
    }
}