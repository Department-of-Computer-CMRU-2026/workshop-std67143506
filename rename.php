<?php

$files = [
    'resources/views/components/admin/⚡workshop-manager.blade.php',
    'resources/views/components/admin/⚡registration-list.blade.php',
    'resources/views/components/admin/⚡dashboard.blade.php',
    'resources/views/components/admin/⚡user-list.blade.php',
    'resources/views/components/student/⚡workshop-list.blade.php',
    'resources/views/dashboard.blade.php',
];

foreach ($files as $file) {
    if (!file_exists($file))
        continue;
    $content = file_get_contents($file);
    $content = str_replace('Workshop', 'Event', $content);
    $content = str_replace('workshop', 'event', $content);
    $content = str_replace('Lecturer', 'Speaker', $content);
    $content = str_replace('lecturer', 'speaker', $content);
    $content = str_replace('Capacity', 'Total Seats', $content);
    $content = str_replace('capacity', 'total_seats', $content);
    file_put_contents($file, $content);
}

@rename('resources/views/components/admin/⚡workshop-manager.blade.php', 'resources/views/components/admin/⚡event-manager.blade.php');
@rename('resources/views/components/student/⚡workshop-list.blade.php', 'resources/views/components/student/⚡event-list.blade.php');

echo "Done\n";
