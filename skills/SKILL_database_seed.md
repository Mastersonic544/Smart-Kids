# Database Seeding Strategy (XAMPP / MySQL 8+)

## 1. SCHEMA OVERVIEW

List of all tables, columns, and relationships required for SmartKids:

- **`users`**: `id`, `name`, `email`, `password`, `role` (admin/educateur/parent), `phone`, `avatar`
- **`children`**: `id`, `first_name`, `last_name`, `dob`, `parent_id` (FK: users.id), `class_id` (FK: classes.id), `allergies`, `photo`, `enrollment_date`
- **`classes`**: `id`, `name`, `level`, `educator_id` (FK: users.id), `max_capacity`, `academic_year`
- **`attendances`**: `id`, `child_id` (FK: children.id), `date`, `status` (Enum: present/absent/late), `reason`
- **`enrollments`**: `id`, `child_id` (FK: children.id), `status` (Enum: active/waitlist/pending), `documents_submitted` (JSON), `created_at`
- **`payments`**: `id`, `child_id` (FK: children.id), `month`, `amount`, `due_date`, `paid_at`, `status` (Enum: pending/paid/overdue), `receipt_path`
- **`activities`**: `id`, `name`, `description`, `date`, `time`, `educator_id` (FK: users.id)
- **`activity_children`** (Pivot): `activity_id` (FK: activities.id), `child_id` (FK: children.id), `attended` (Boolean)
- **`meals`**: `id`, `week_start` (Date), `monday`, `tuesday`, `wednesday`, `thursday`, `friday` (JSON columns for menus)
- **`notifications`**: `id`, `user_id` (FK: users.id), `type`, `data` (JSON), `read_at` (Datetime)
- **`messages`**: `id`, `sender_id` (FK: users.id), `receiver_id` (FK: users.id), `body` (Text), `read_at` (Datetime)

## 2. SEEDER STRATEGY
Ensure the system is populated with realistic dummy data for testing the UI.

- 1 admin user
- 4 educators (Tunisian Arabic names)
- 20 parents (Tunisian names)
- 35 children (realistic ages 2-5, mixed genders, some realistically have allergies)
- 4 classes: Petite section, Moyenne section, Grande section, Nursery
- 3 months of attendance records
- 2 months of payment records (mix of paid, pending, overdue)
- 10 activities with simulated participation records
- 4 weeks of meal menus (French text)

**Master Seeder (`database/seeders/DatabaseSeeder.php`):**
```php
public function run()
{
    $this->call([
        RoleSeeder::class,     // Setup spatie roles
        UserSeeder::class,     // Admins, Educators, Parents
        ClassSeeder::class,    // 4 section classes
        ChildSeeder::class,    // 35 children assigned to parents/classes
        EnrollmentSeeder::class,
        AttendanceSeeder::class, // 3 months history
        PaymentSeeder::class,    // 2 months history
        ActivitySeeder::class, 
        MealSeeder::class,
    ]);
}
```

## 3. FACTORY DEFINITIONS
Use Laravel Factories (`database/factories/...`) configured with the `fr_TN` (French - Tunisia) Faker locale where possible. For older Faker versions without `fr_TN`, `fr_FR` or injecting a custom Tunisian name array works.

```php
// config/app.php
'faker_locale' => 'fr_FR', 
```

**ChildFactory.php Example:**
```php
public function definition()
{
    return [
        'first_name' => $this->faker->firstName(),
        'last_name' => $this->faker->lastName(),
        'dob' => $this->faker->dateTimeBetween('-5 years', '-2 years')->format('Y-m-d'), // Ages 2-5
        'allergies' => $this->faker->boolean(20) ? 'Arachides, Lait' : null, // 20% risk
        'enrollment_date' => $this->faker->dateTimeBetween('-1 year', 'now')->format('Y-m-d'),
    ];
}
```

## 4. SQL DUMP ALTERNATIVE
For teams avoiding Artisan Seeders, you can import this directly via **phpMyAdmin** in XAMPP:

```sql
-- Insert specific parent users
INSERT INTO `users` (`id`, `name`, `email`, `password`, `role`, `phone`) VALUES
(101, 'Amine Trabelsi', 'amine@example.tn', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'parent', '20123456'),
(102, 'Sami Ben Ali', 'sami@example.tn', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'parent', '98123456'),
(103, 'Fatma Gharbi', 'fatma@example.tn', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'parent', '52123456'),
(104, 'Youssef Jlassi', 'youssef@example.tn', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'parent', '21123456'),
(105, 'Mariem Mansour', 'mariem@example.tn', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'parent', '55123456');

-- Insert children
INSERT INTO `children` (`id`, `first_name`, `last_name`, `dob`, `parent_id`, `class_id`, `allergies`, `enrollment_date`) VALUES
(1, 'Ahmed', 'Trabelsi', '2020-05-15', 101, 1, NULL, '2023-09-01'),
(2, 'Sarah', 'Ben Ali', '2019-11-20', 102, 2, 'Gluten', '2023-09-01'),
(3, 'Yassine', 'Gharbi', '2021-02-10', 103, 1, NULL, '2023-09-01'),
(4, 'Nour', 'Jlassi', '2018-08-05', 104, 3, 'Lait', '2022-09-01'),
(5, 'Omar', 'Mansour', '2020-12-30', 105, 1, NULL, '2024-01-15');
```

## 5. HOW TO RUN

**Using Laravel Commands:**
1. Wipe the database, run all migrations, and run all seeders (Warning: destroys all data):
   ```bash
   php artisan migrate:fresh --seed
   ```
2. Run a specific seeder class only:
   ```bash
   php artisan db:seed --class=ChildSeeder
   ```

**Using XAMPP phpMyAdmin (SQL Import):**
1. Ensure Apache and MySQL are running in the XAMPP Control Panel.
2. Open `http://localhost/phpmyadmin`.
3. Select your Database (`smartkids_db`).
4. Click the "Import" tab at the top.
5. Upload `.sql` file or paste raw SQL queries into the SQL command window and click "Go".
