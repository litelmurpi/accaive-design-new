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

        // 9. SITE SETTINGS (Complete CMS Default Content & Visual UI Editor)
        DB::table('site_settings')->insert([
            // Homepage: Layout & Structure
            ['key' => 'home_sections', 'value' => json_encode([
                ['id' => 'hero', 'is_visible' => true],
                ['id' => 'projects', 'is_visible' => true],
                ['id' => 'services', 'is_visible' => true],
                ['id' => 'team', 'is_visible' => true],
                ['id' => 'cta', 'is_visible' => true],
            ])],
            ['key' => 'home_projects_layout', 'value' => 'asymmetric'],
            ['key' => 'home_services_layout', 'value' => 'split'],

            // Homepage: Hero
            ['key' => 'site_title', 'value' => 'Accaive Design Studio'],
            ['key' => 'hero_title_prefix', 'value' => 'a creation that'],
            ['key' => 'hero_title_accent', 'value' => 'craves'],
            ['key' => 'hero_title_suffix', 'value' => 'creative design.'],
            ['key' => 'hero_headline', 'value' => "a creation that <br /> <span class='italic'>craves</span> <br /> <span class='italic'>creative</span> design."],
            ['key' => 'hero_award_subtitle', 'value' => '7x Agency of the Year'],
            ['key' => 'hero_awards', 'value' => json_encode(['ArchDaily 2024', 'Pritzker Mention 2023', 'Dezeen Awards 2024', 'AIA Firm of Year 2025'])],
            ['key' => 'hero_video_url', 'value' => ''],
            ['key' => 'hero_video_poster', 'value' => 'https://images.unsplash.com/photo-1486325212027-8081e485255e?q=80&w=2070&auto=format&fit=crop'],
            
            // Homepage: Services Section
            ['key' => 'home_services_label', 'value' => 'Programs & Services'],
            ['key' => 'home_services_heading', 'value' => 'Eleven ways we help clients build and command their unique environments.'],
            ['key' => 'home_services_button_text', 'value' => 'Explore Programs'],
            ['key' => 'home_services_button_url', 'value' => '/programs'],

            // Homepage: Projects Section
            ['key' => 'home_projects_heading', 'value' => 'Our Projects'],
            ['key' => 'home_projects_subheading', 'value' => 'We design structures so compelling, their impact is inevitable.'],
            ['key' => 'home_projects_button_text', 'value' => 'View All Projects'],

            // Homepage: Team Section
            ['key' => 'home_team_label', 'value' => 'Team'],
            ['key' => 'home_team_heading', 'value' => 'Meet the makers.'],
            ['key' => 'home_team_description', 'value' => 'We asked our team to choose a piece of architecture that represents them. From brutalist monuments to sustainable dwellings. Different backgrounds, same high standards.'],

            // Homepage & Global: CTA Section
            ['key' => 'home_cta_title', 'value' => 'Have an idea?'],
            ['key' => 'home_cta_accent', 'value' => "Let's build it."],
            ['key' => 'home_cta_heading', 'value' => "Have an idea? <br /> <span class='italic opacity-50'>Let's build it.</span>"],
            ['key' => 'home_cta_description', 'value' => "We collaborate with ambitious brands and people. Let's make something great together."],
            ['key' => 'home_cta_button_text', 'value' => 'Start a Project'],

            // Subpages: Programs
            ['key' => 'programs_hero_title', 'value' => 'Programs'],
            ['key' => 'programs_hero_heading', 'value' => 'Eleven ways we help brands find and command their unique premium.'],
            ['key' => 'programs_impact_title', 'value' => 'Our Programs Deliver Impact'],
            ['key' => 'programs_impacts', 'value' => json_encode(['Establish Market Distinction', 'Create Cultural Relevance', 'Command Premium Pricing', 'Optimize Portfolios', 'Accelerate Growth', 'Open Market Opportunity'])],

            // Subpages: Arts & Culture
            ['key' => 'arts_hero_title', 'value' => 'Arts & Culture'],
            ['key' => 'arts_hero_description', 'value' => 'Exploring the intersection of design, heritage, and modern artistic expression.'],

            // Subpages: Team
            ['key' => 'team_page_title', 'value' => 'Our Team'],
            ['key' => 'team_page_subtitle', 'value' => 'The minds and makers behind Accaive.'],
            ['key' => 'team_join_title', 'value' => 'Join the Collective'],
            ['key' => 'team_join_description', 'value' => 'We are always looking for visionary talent to join our multidisciplinary team.'],
            ['key' => 'team_join_button_text', 'value' => 'View Openings'],

            // Subpages: Careers
            ['key' => 'careers_hero_title', 'value' => 'Careers'],
            ['key' => 'careers_hero_description', 'value' => 'Join us in shaping the future of built environments.'],

            // Subpages: Press
            ['key' => 'press_hero_title', 'value' => 'Press'],
            ['key' => 'press_hero_description', 'value' => 'Latest news, awards, and features.'],

            // Contact & Socials
            ['key' => 'contact_email', 'value' => 'hello@accaivedesign.com'],
            ['key' => 'contact_phone', 'value' => '+62 812-3456-7890'],
            ['key' => 'contact_address', 'value' => 'Jakarta, Indonesia'],
            ['key' => 'social_instagram', 'value' => 'https://instagram.com/accaivedesign'],
            ['key' => 'social_linkedin', 'value' => 'https://linkedin.com/company/accaivedesign'],
            ['key' => 'social_twitter', 'value' => 'https://x.com/accaivedesign'],

            // Footer
            ['key' => 'footer_tagline', 'value' => 'Keep up to date'],
            ['key' => 'footer_copyright', 'value' => 'Accaive Design Studio. All rights reserved.'],

            // Search Engine Optimization (SEO)
            ['key' => 'seo_meta_title', 'value' => 'Accaive Design — Architecture & Built Environments Studio'],
            ['key' => 'seo_meta_description', 'value' => 'Accaive Design Studio (accaivedesign.id) adalah biro arsitektur, interior, dan tata lingkungan visioner berbasis di Kotagede, Yogyakarta & Jakarta. We design structures so compelling, their impact is inevitable.'],
            ['key' => 'seo_keywords', 'value' => json_encode(['Accaive', 'Accaive Design', 'Accaive Studio', 'Accaive Std', 'Studio Arsitek Yogyakarta', 'Arsitek Kotagede', 'Biro Arsitek Jakarta', 'Luxury Architecture Indonesia'])],
            ['key' => 'seo_google_verification', 'value' => ''],
        ]);

        DB::table('users')->insert([
            ['name' => 'Admin Accaive', 'email' => 'admin@accaive.com', 'password' => bcrypt('password')]
        ]);
    }
}
