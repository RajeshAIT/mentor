<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            ['job_title' => "Academic librarian"],
            ['job_title' => "Accountant"],
            ['job_title' => "Accounting technician"],
            ['job_title' => "Actuary"],
            ['job_title' => "Adult nurse"],
            ['job_title' => "Advertising account executive"],
            ['job_title' => "Advertising account planner"],
            ['job_title' => "Advertising copywriter"],
            ['job_title' => "Advice worker"],
            ['job_title' => "Advocate (Scotland)"],
            ['job_title' => "Aeronautical engineer"],
            ['job_title' => "Agricultural consultant"],
            ['job_title' => "Agricultural manager"],
            ['job_title' => "Aid worker/humanitarian worker"],
            ['job_title' => "Air traffic controller"],
            ['job_title' => "Auditor"],
            ['job_title' => "Barrister"],
            ['job_title' => "Barrister’s clerk"],
            ['job_title' => "Bilingual secretary"],
            ['job_title' => "Biomedical engineer"],
            ['job_title' => "Biomedical scientist"],
            ['job_title' => "Biotechnologist"],
            ['job_title' => "Brand manager"],
            ['job_title' => "Broadcasting presenter"],
            ['job_title' => "Building control officer/surveyor"],
            ['job_title' => "Building services engineer"],
            ['job_title' => "Building surveyor"],
            ['job_title' => "Camera operator"],
            ['job_title' => "Careers adviser (higher education)"],
            ['job_title' => "Careers adviser"],
            ['job_title' => "Careers consultant"],
            ['job_title' => "Cartographer"],
            ['job_title' => "Catering manager"],
            ['job_title' => "Charities administrator"],
            ['job_title' => "Charities fundraiser"],
            ['job_title' => "Chemical (process) engineer"],
            ['job_title' => "Child psychotherapist"],
            ['job_title' => "Children's nurse"],
            ['job_title' => "Chiropractor"],
            ['job_title' => "Consultant"],
            ['job_title' => "Counsellor"],
            ['job_title' => "Curator"],
            ['job_title' => "Dramatherapist"],
            ['job_title' => "Dietitian"],
            ['job_title' => "Economist"],
            ['job_title' => "Ergonomist"],
            ['job_title' => "European Commission administrators"],
            ['job_title' => "Firefighter"],
            ['job_title' => "Fisheries officer"],
            ['job_title' => "Geneticist"],
            ['job_title' => "Geographical information systems manager"],
            ['job_title' => "Herbalist"],
            ['job_title' => "Government lawyer"],
            ['job_title' => "Homeless worker"],
            ['job_title' => "Hydrologist"],
            ['job_title' => "Illustrator"],
            ['job_title' => "Immunologist"],
            ['job_title' => "Insurance broker"],
            ['job_title' => "Interpreter"],
            ['job_title' => "IT consultant"],
            ['job_title' => "Learning mentor"],
            ['job_title' => "Magazine features editor"],
            ['job_title' => "Media analyst"],
            ['job_title' => "Media buyer"],
            ['job_title' => "Media planner"],
            ['job_title' => "Metallurgist"],
            ['job_title' => "Meteorologist"],
            ['job_title' => "Microbiologist"],
            ['job_title' => "Nurse"],
            ['job_title' => "Orthoptist"],
            ['job_title' => "Paramedic"],
            ['job_title' => "Pharmacist"],
            ['job_title' => "Pharmacologist"],
            ['job_title' => "Photographer"],
            ['job_title' => "Physiotherapist"],
            ['job_title' => "Plant breeder"],
            ['job_title' => "Police officer"],
            ['job_title' => "QA analyst"],
            ['job_title' => "Recycling officer"],
            ['job_title' => "Sports therapist"],
            ['job_title' => "Tax inspector"],
            ['job_title' => "Tourism officer"],
            ['job_title' => "Youth worker"],
            ['job_title' => "UX designer"],
            ['job_title' => "Translator"],
            ['job_title' => "Warehouse manager"],
            ['job_title' => "Waste disposal officer"],
            ['job_title' => "Web designer"],
            ['job_title' => "Web developer"],
            ['job_title' => "Welfare rights adviser"],
            ['job_title' => "Tour operator"],
            ['job_title' => "Technical author"],
            ['job_title' => "Tax inspector"],
            ['job_title' => "Sports coach"],
            ['job_title' => "Solicitor"],
            ['job_title' => "Sales manager"],
            ['job_title' => "Retail manager"]  
        ];
        
        Category::insert($data);
    }
}
