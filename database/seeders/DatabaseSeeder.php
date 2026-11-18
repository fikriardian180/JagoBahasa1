<?php

namespace Database\Seeders;

use App\Models\Badge;
use App\Models\Classroom;
use App\Models\Course;
use App\Models\Enrollment;
use App\Models\Institution;
use App\Models\Lesson;
use App\Models\Module;
use App\Models\Quiz;
use App\Models\QuizAttempt;
use App\Models\QuizQuestion;
use App\Models\User;
use App\Models\UserProgress;
use App\Models\XpLog;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Create Institutions
        $unida = Institution::create([
            'name' => 'Universitas Darussalam Gontor',
            'email_domain' => 'unida.gontor.ac.id',
            'default_role' => 'staff',
            'is_active' => true,
        ]);

        $ui = Institution::create([
            'name' => 'Universitas Indonesia',
            'email_domain' => 'ui.ac.id',
            'default_role' => 'staff',
            'is_active' => true,
        ]);

        // 2. Create Badges
        $badges = [
            ['code' => 'first_lesson', 'name' => 'Pioneer Learner', 'description' => 'Menyelesaikan lesson pertama Anda.', 'icon' => '🌟', 'criteria' => 'Complete 1 lesson'],
            ['code' => 'streak_7', 'name' => '7-Day Streak', 'description' => 'Belajar konsisten selama 7 hari berturut-turut.', 'icon' => '🔥', 'criteria' => 'Maintain 7-day streak'],
            ['code' => 'speaking_master', 'name' => 'Pronunciation Pro', 'description' => 'Meraih skor Speaking di atas 90%.', 'icon' => '🎙️', 'criteria' => 'Score >= 90 in Speaking Lab'],
            ['code' => 'grammar_expert', 'name' => 'Grammar Wizard', 'description' => 'Menyelesaikan Writing Check dengan sempurna.', 'icon' => '✍️', 'criteria' => 'Complete Writing Check'],
        ];

        $createdBadges = [];
        foreach ($badges as $badgeData) {
            $createdBadges[] = Badge::create($badgeData);
        }

        // 3. Create 20 Demo Accounts across 5 roles
        $password = Hash::make('password');

        // Admins (2)
        $admin1 = User::create([
            'name' => 'Super Administrator',
            'email' => 'admin@jagobahasa.test',
            'password' => $password,
            'role' => 'admin',
            'is_active' => true,
            'email_verified_at' => now(),
            'xp_points' => 1250,
            'current_streak' => 15,
            'longest_streak' => 30,
        ]);

        User::create([
            'name' => 'System Co-Admin',
            'email' => 'admin2@jagobahasa.test',
            'password' => $password,
            'role' => 'admin',
            'is_active' => true,
            'email_verified_at' => now(),
            'xp_points' => 950,
            'current_streak' => 10,
            'longest_streak' => 20,
        ]);

        // Lecturers (3)
        $lecturer1 = User::create([
            'name' => 'Dr. Ahmad Fauzi, M.Pd.',
            'email' => 'lecturer1@jagobahasa.test',
            'password' => $password,
            'role' => 'lecturer',
            'institution_id' => $unida->id,
            'is_institutional' => true,
            'is_active' => true,
            'email_verified_at' => now(),
            'xp_points' => 820,
            'current_streak' => 12,
            'longest_streak' => 25,
        ]);

        $lecturer2 = User::create([
            'name' => 'Sarah Jenkins, Ph.D.',
            'email' => 'lecturer2@jagobahasa.test',
            'password' => $password,
            'role' => 'lecturer',
            'institution_id' => $ui->id,
            'is_institutional' => true,
            'is_active' => true,
            'email_verified_at' => now(),
            'xp_points' => 760,
            'current_streak' => 8,
            'longest_streak' => 14,
        ]);

        User::create([
            'name' => 'Budi Santoso, M.A.',
            'email' => 'lecturer3@jagobahasa.test',
            'password' => $password,
            'role' => 'lecturer',
            'institution_id' => $unida->id,
            'is_institutional' => true,
            'is_active' => true,
            'email_verified_at' => now(),
            'xp_points' => 540,
            'current_streak' => 5,
            'longest_streak' => 10,
        ]);

        // Students (10)
        $students = [];
        for ($i = 1; $i <= 10; $i++) {
            $students[] = User::create([
                'name' => "Mahasiswa Demo {$i}",
                'email' => "student{$i}@student.unida.gontor.ac.id",
                'student_number' => '2026' . str_pad($i, 4, '0', STR_PAD_LEFT),
                'password' => $password,
                'role' => 'student',
                'institution_id' => $unida->id,
                'is_institutional' => true,
                'is_active' => true,
                'email_verified_at' => now(),
                'xp_points' => rand(150, 650),
                'current_streak' => rand(1, 10),
                'longest_streak' => rand(5, 15),
            ]);
        }

        // Staff (3)
        for ($i = 1; $i <= 3; $i++) {
            User::create([
                'name' => "Tenaga Kependidikan {$i}",
                'email' => "staff{$i}@unida.gontor.ac.id",
                'password' => $password,
                'role' => 'staff',
                'institution_id' => $unida->id,
                'is_institutional' => true,
                'is_active' => true,
                'email_verified_at' => now(),
                'xp_points' => rand(100, 300),
                'current_streak' => rand(1, 4),
                'longest_streak' => rand(4, 8),
            ]);
        }

        // Guests (2)
        User::create([
            'name' => 'Guest Alumnus Visitor',
            'email' => 'guest1@gmail.com',
            'password' => $password,
            'role' => 'guest',
            'is_active' => true,
            'email_verified_at' => now(),
            'xp_points' => 80,
            'current_streak' => 2,
            'longest_streak' => 3,
        ]);

        User::create([
            'name' => 'Dewan Juri Tamu YLIC',
            'email' => 'juri@ylic2026.test',
            'password' => $password,
            'role' => 'guest',
            'is_active' => true,
            'email_verified_at' => now(),
            'xp_points' => 500,
            'current_streak' => 7,
            'longest_streak' => 7,
        ]);

        // 4. Create 2 English Courses
        $course1 = Course::create([
            'owner_id' => $lecturer1->id,
            'title' => 'English for Academic Excellence (CEFR B1)',
            'slug' => 'english-academic-excellence-b1',
            'level' => 'B1',
            'category' => 'academic',
            'description' => 'Comprehensive academic English course focusing on essay writing, advanced listening comprehension, and professional speaking.',
            'visibility' => 'public',
            'is_published' => true,
        ]);

        $course2 = Course::create([
            'owner_id' => $lecturer2->id,
            'title' => 'Foundational English Communication (CEFR A1)',
            'slug' => 'foundational-english-communication-a1',
            'level' => 'A1',
            'category' => 'general',
            'description' => 'Beginner-friendly English course designed to build confidence in everyday conversations, pronunciation, and basic grammar.',
            'visibility' => 'public',
            'is_published' => true,
        ]);

        // 5. Create Modules & Lessons for Course 1 (4 modules)
        $skills1 = ['listening', 'speaking', 'reading', 'writing'];
        for ($m = 1; $m <= 4; $m++) {
            $module = Module::create([
                'course_id' => $course1->id,
                'title' => "Module {$m}: " . ucfirst($skills1[$m - 1]) . ' Mastery',
                'skill_focus' => $skills1[$m - 1],
                'order_number' => $m,
            ]);

            for ($l = 1; $l <= 2; $l++) {
                Lesson::create([
                    'module_id' => $module->id,
                    'title' => "Lesson {$m}.{$l}: Advanced " . ucfirst($skills1[$m - 1]) . " Practice",
                    'content_text' => "This is the comprehensive learning material for lesson {$m}.{$l} covering advanced academic concepts, vocabulary usage, and practical exercises.",
                    'audio_url' => null,
                    'transcript' => "Transcript for lesson {$m}.{$l}: Education is the most powerful weapon which you can use to change the world.",
                    'vocabulary' => [
                        ['term' => 'Academic', 'meaning' => 'Relating to education and scholarship', 'example' => 'Academic excellence is our primary goal.'],
                        ['term' => 'Innovation', 'meaning' => 'A new method, idea, or product', 'example' => 'Youth learning innovation empowers society.'],
                    ],
                    'speaking_target_phrase' => 'Education is the key to global sustainable development.',
                    'grammar_prompt' => 'Rewrite the following sentence in the passive voice with correct punctuation.',
                    'xp_reward' => 50,
                    'order_number' => $l,
                ]);
            }
        }

        // Create Modules & Lessons for Course 2 (4 modules)
        $skills2 = ['reading', 'listening', 'speaking', 'writing'];
        for ($m = 1; $m <= 4; $m++) {
            $module = Module::create([
                'course_id' => $course2->id,
                'title' => "Foundational Module {$m}: " . ucfirst($skills2[$m - 1]),
                'skill_focus' => $skills2[$m - 1],
                'order_number' => $m,
            ]);

            for ($l = 1; $l <= 2; $l++) {
                Lesson::create([
                    'module_id' => $module->id,
                    'title' => "Basic Lesson {$m}.{$l}: Everyday " . ucfirst($skills2[$m - 1]),
                    'content_text' => "Friendly beginner content for lesson {$m}.{$l} designed for daily communication skills.",
                    'audio_url' => null,
                    'transcript' => "Hello everyone, welcome to JagoBahasa foundational learning room.",
                    'vocabulary' => [
                        ['term' => 'Welcome', 'meaning' => 'An instance or manner of greeting someone', 'example' => 'Welcome to our inclusive LMS.'],
                    ],
                    'speaking_target_phrase' => 'Nice to meet you, let us learn English together.',
                    'grammar_prompt' => 'Correct the verb tense in this sentence.',
                    'xp_reward' => 40,
                    'order_number' => $l,
                ]);
            }
        }

        // 6. Create Pre-Test & Post-Test Quizzes for each Course
        foreach ([$course1, $course2] as $course) {
            // Pre-Test
            $preQuiz = Quiz::create([
                'course_id' => $course->id,
                'module_id' => null,
                'title' => 'Initial Diagnostic Pre-Test',
                'type' => 'pre_test',
            ]);

            QuizQuestion::create([
                'quiz_id' => $preQuiz->id,
                'question_text' => 'Choose the correct grammatical form: She _____ to the library yesterday.',
                'options' => ['goes', 'went', 'gone', 'going'],
                'correct_answer' => 'went',
                'explanation' => 'Past simple tense is required because of the time marker "yesterday".',
            ]);

            QuizQuestion::create([
                'quiz_id' => $preQuiz->id,
                'question_text' => 'What is the synonym of "Inconclusive"?',
                'options' => ['Certain', 'Definite', 'Uncertain', 'Clear'],
                'correct_answer' => 'Uncertain',
                'explanation' => 'Inconclusive means not leading to a clear conclusion or uncertain.',
            ]);

            // Post-Test
            $postQuiz = Quiz::create([
                'course_id' => $course->id,
                'module_id' => null,
                'title' => 'Final Impact Assessment Post-Test',
                'type' => 'post_test',
            ]);

            QuizQuestion::create([
                'quiz_id' => $postQuiz->id,
                'question_text' => 'Identify the correct passive voice sentence for: "The teacher explains the lesson."',
                'options' => [
                    'The lesson was explained by the teacher.',
                    'The lesson is explained by the teacher.',
                    'The lesson has explained by the teacher.',
                    'The lesson explains the teacher.'
                ],
                'correct_answer' => 'The lesson is explained by the teacher.',
                'explanation' => 'Present simple active "explains" converts to present simple passive "is explained".',
            ]);
        }

        // 7. Create 2 Active Classrooms & Enrollments
        $class1 = Classroom::create([
            'lecturer_id' => $lecturer1->id,
            'course_id' => $course1->id,
            'name' => 'B1 Advanced Academic English - Class A',
            'join_code' => 'ENG-B1-2026',
            'academic_year' => '2025/2026',
            'is_active' => true,
        ]);

        $class2 = Classroom::create([
            'lecturer_id' => $lecturer2->id,
            'course_id' => $course2->id,
            'name' => 'A1 Foundational Communication Lab - Class B',
            'join_code' => 'ENG-A1-2026',
            'academic_year' => '2025/2026',
            'is_active' => true,
        ]);

        // Enroll students into classrooms and seed progress
        foreach ($students as $index => $student) {
            $targetClass = ($index % 2 === 0) ? $class1 : $class2;

            Enrollment::create([
                'classroom_id' => $targetClass->id,
                'user_id' => $student->id,
                'joined_at' => now(),
            ]);

            // Assign some completed lessons & badges
            $lessons = Lesson::whereHas('module', function ($q) use ($targetClass) {
                $q->where('course_id', $targetClass->course_id);
            })->take(3)->get();

            foreach ($lessons as $lesson) {
                UserProgress::create([
                    'user_id' => $student->id,
                    'lesson_id' => $lesson->id,
                    'status' => 'completed',
                    'speaking_score' => rand(80, 98),
                    'quiz_score' => rand(85, 100),
                    'writing_score' => rand(82, 95),
                    'attempts' => 1,
                    'completed_at' => now(),
                ]);
            }

            // Award badge
            $student->badges()->attach($createdBadges[array_rand($createdBadges)]->id, ['awarded_at' => now()]);

            // Log XP
            XpLog::create([
                'user_id' => $student->id,
                'source' => 'lesson',
                'points' => 150,
            ]);
        }
    }
}
