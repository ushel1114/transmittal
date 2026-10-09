<?php

it('includes Tarlac barangay data in the location csv', function () {
    $csvPath = base_path('location.csv');
    $content = file_get_contents($csvPath);

    expect($content)
        ->toContain('Baguindoc,Anao,Tarlac')
        ->and($content)->toContain('Abang-Singit,Bamban,Tarlac')
        ->and($content)->toContain('Poblacion Center,Capas,Tarlac')
        ->and($content)->toContain('Matawe,Dingalan,Aurora');
});

it('includes Matawe in the add and edit location dropdown data', function () {
    $locationRow = 'Matawe,Dingalan,Aurora';
    $dropdownSources = [
        resource_path('js/app.js'),
        resource_path('views/admin.blade.php'),
        resource_path('views/facebook-handler.blade.php'),
    ];

    foreach ($dropdownSources as $source) {
        expect(file_get_contents($source))->toContain($locationRow);
    }
});
