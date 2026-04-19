<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. SERVICES
        DB::table('services')->insert([
            ['code' => '01', 'title' => 'Spatial Strategy', 'description' => 'Aligning physical space with organizational vision.', 'sort_order' => 1],
            ['code' => '02', 'title' => 'Adaptive Reuse', 'description' => 'Breathing new life into historic structures.', 'sort_order' => 2],
            ['code' => '03', 'title' => 'Urban Planning', 'description' => 'Designing sustainable communities for the future.', 'sort_order' => 3],
            ['code' => '04', 'title' => 'Interior Ecosystems', 'description' => 'Curating environments that foster well-being.', 'sort_order' => 4],
            ['code' => '05', 'title' => 'Brand Architecture', 'description' => 'Translating brand identity into built form.', 'sort_order' => 5],
        ]);

        // 2. TEAM MEMBERS
        DB::table('team_members')->insert([
            ['name' => 'Alex Vanhoven', 'role' => 'Principal Architect', 'photo' => 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?q=80&w=2574&auto=format&fit=crop', 'sort_order' => 1],
            ['name' => 'Sarah Chen', 'role' => 'Design Director', 'photo' => 'https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?q=80&w=2576&auto=format&fit=crop', 'sort_order' => 2],
            ['name' => 'Marcus Thorne', 'role' => 'Urban Planner', 'photo' => 'https://images.unsplash.com/photo-1500648767791-00dcc994a43e?q=80&w=2574&auto=format&fit=crop', 'sort_order' => 3],
            ['name' => 'Elara Vance', 'role' => 'Interior Lead', 'photo' => 'https://images.unsplash.com/photo-1580489944761-15a19d654956?q=80&w=2661&auto=format&fit=crop', 'sort_order' => 4],
            ['name' => 'Davide Rosso', 'role' => 'Technical Director', 'photo' => 'https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?q=80&w=2670&auto=format&fit=crop', 'sort_order' => 5],
            ['name' => 'Priya Patel', 'role' => 'Sustainability Lead', 'photo' => 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?q=80&w=2564&auto=format&fit=crop', 'sort_order' => 6],
        ]);

        // 3. PROJECTS
        $gallery = json_encode([
            "https://images.unsplash.com/photo-1600596542815-ffad4c1539a9?q=80&w=2075&auto=format&fit=crop",
            "https://images.unsplash.com/photo-1628744448840-55bdb2497bd4?q=80&w=2670&auto=format&fit=crop",
            "https://images.unsplash.com/photo-1512917774080-9991f1c4c750?q=80&w=2070&auto=format&fit=crop"
        ]);
        DB::table('projects')->insert([
            ['title' => 'The Void House', 'slug' => 'the-void-house', 'category' => 'Residential', 'client' => 'Private Client', 'year' => '2025', 'description' => 'A visionary design that emphasizes the connection between interior spaces and natural surroundings...', 'hero_image' => 'https://images.unsplash.com/photo-1600607686527-6fb886090705?q=80&w=2727&auto=format&fit=crop', 'size' => 'large', 'span' => 'md:col-span-7', 'gallery_images' => $gallery, 'is_featured' => true, 'sort_order' => 1],
            ['title' => 'Nebula Tower', 'slug' => 'nebula-tower', 'category' => 'Commercial', 'client' => 'Global Corp', 'year' => '2025', 'description' => 'A visionary design...', 'hero_image' => 'https://images.unsplash.com/photo-1486718448742-163732cd1544?q=80&w=2600&auto=format&fit=crop', 'size' => 'small', 'span' => 'md:col-span-5', 'gallery_images' => $gallery, 'is_featured' => true, 'sort_order' => 2],
            ['title' => 'Silence Pavilion', 'slug' => 'silence-pavilion', 'category' => 'Cultural', 'client' => 'City Council', 'year' => '2025', 'description' => 'A visionary design...', 'hero_image' => 'https://images.unsplash.com/photo-1628744448840-55bdb2497bd4?q=80&w=2670&auto=format&fit=crop', 'size' => 'tall', 'span' => 'md:col-span-4', 'gallery_images' => $gallery, 'is_featured' => true, 'sort_order' => 3],
            ['title' => 'Echo Library', 'slug' => 'echo-library', 'category' => 'Public', 'client' => 'University Foundation', 'year' => '2025', 'description' => 'A visionary design...', 'hero_image' => 'https://images.unsplash.com/photo-1544984243-ec57ea16fe25?q=80&w=2574&auto=format&fit=crop', 'size' => 'wide', 'span' => 'md:col-span-8', 'gallery_images' => $gallery, 'is_featured' => true, 'sort_order' => 4],
            ['title' => 'Horizon Villa', 'slug' => 'horizon-villa', 'category' => 'Residential', 'client' => 'Private Client', 'year' => '2025', 'description' => 'A visionary design...', 'hero_image' => 'https://images.unsplash.com/photo-1600585154340-be6161a56a0c?q=80&w=2670&auto=format&fit=crop', 'size' => 'large', 'span' => 'md:col-span-6', 'gallery_images' => $gallery, 'is_featured' => true, 'sort_order' => 5],
            ['title' => 'Apex HQ', 'slug' => 'apex-hq', 'category' => 'Workplace', 'client' => 'Apex Corp', 'year' => '2025', 'description' => 'A visionary design...', 'hero_image' => 'https://images.unsplash.com/photo-1497366216548-37526070297c?q=80&w=2669&auto=format&fit=crop', 'size' => 'small', 'span' => 'md:col-span-6', 'gallery_images' => $gallery, 'is_featured' => true, 'sort_order' => 6],
        ]);

        // 4. EXHIBITIONS
        DB::table('exhibitions')->insert([
            ['title' => 'Modern Heritage', 'location' => 'London, UK', 'year' => '2023', 'image' => 'https://images.unsplash.com/photo-1518998053901-5348d3969105?q=80&w=2592&auto=format&fit=crop'],
            ['title' => 'Light & Shadow', 'location' => 'Tokyo, Japan', 'year' => '2022', 'image' => 'https://images.unsplash.com/photo-1507643179173-617d654f3daf?q=80&w=2668&auto=format&fit=crop'],
            ['title' => 'The Silent Gallery', 'location' => 'Berlin, Germany', 'year' => '2024', 'image' => 'https://images.unsplash.com/photo-1545989253-02cc26577f88?q=80&w=2670&auto=format&fit=crop'],
        ]);

        // 5. PRESS ARTICLES
        DB::table('press_articles')->insert([
            ['title' => 'Redefining the Workplace: Accaive\'s Approach to Post-Pandemic Office Design', 'source' => 'Architectural Digest', 'published_at' => '2024-03-01'],
            ['title' => 'Top 10 Emerging Architecture Firms to Watch in 2024', 'source' => 'Dezeen', 'published_at' => '2024-02-15'],
            ['title' => 'The Void House: A Masterclass in Minimalist Living', 'source' => 'Dwell Magazine', 'published_at' => '2024-01-22'],
            ['title' => 'Sustainable Urbanism: How Accaive is Rethinking the City Block', 'source' => 'Metropolis', 'published_at' => '2023-11-10'],
        ]);

        // 6. JOB OPENINGS
        DB::table('job_openings')->insert([
            ['title' => 'Senior Architect', 'department' => 'Architecture', 'location' => 'New York, Hybrid', 'type' => 'Full-time'],
            ['title' => 'Junior Interior Designer', 'department' => 'Interior Design', 'location' => 'London, Studio', 'type' => 'Full-time'],
            ['title' => 'BIM Coordinator', 'department' => 'Technical', 'location' => 'Remote', 'type' => 'Full-time'],
            ['title' => 'Marketing Intern', 'department' => 'Communications', 'location' => 'New York, Studio', 'type' => 'Internship'],
        ]);

        // 7. PROGRAMS
        DB::table('programs')->insert([
            [
                'title' => 'Design Incubator',
                'subtitle' => 'For Emerging Talent',
                'description' => 'A six-month intensive program where young architects work alongside our partners on theoretical projects.',
                'image' => 'https://images.unsplash.com/photo-1541888086225-ee9b418fb5d8?q=80&w=2670&auto=format&fit=crop',
                'features' => json_encode(['Mentorship from partners', 'Access to studio resources', 'Weekly design critiques', 'Final exhibition showcase'])
            ],
            [
                'title' => 'Urban Research Lab',
                'subtitle' => 'Continuing Education',
                'description' => 'An ongoing initiative exploring how macro trends impact micro living spaces in densely populated cities.',
                'image' => 'https://images.unsplash.com/photo-1481026469463-663274ab8ffa?q=80&w=2592&auto=format&fit=crop',
                'features' => json_encode(['Collaborative research projects', 'Published whitepapers', 'Monthly seminar series', 'Cross-disciplinary teams'])
            ]
        ]);

        // 8. FEATURED STORIES / MENU HIGHLIGHTS
        DB::table('featured_stories')->insert([
            ['title' => 'Designing the Future of Work', 'category' => 'Article', 'image' => 'https://images.unsplash.com/photo-1497366216548-37526070297c?q=80&w=2669&auto=format&fit=crop', 'url' => '#'],
            ['title' => 'The Void House Tour', 'category' => 'Project', 'image' => 'https://images.unsplash.com/photo-1600607686527-6fb886090705?q=80&w=2727&auto=format&fit=crop', 'url' => '#'],
        ]);

        // 9. SITE SETTINGS
        DB::table('site_settings')->insert([
            ['key' => 'site_title', 'value' => 'Accaive Design \u2014 Architecture & Design Studio'],
            ['key' => 'contact_email', 'value' => 'hello@accaivedesign.com'],
        ]);
    }
}
