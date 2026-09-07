<?php

it('includes Tarlac barangay data in the location csv', function () {
    $csvPath = base_path('location.csv');
    $content = file_get_contents($csvPath);

    expect($content)
        ->toContain('Baguindoc,Anao,Tarlac')
        ->and($content)->toContain('Abang-Singit,Bamban,Tarlac')
        ->and($content)->toContain('Poblacion Center,Capas,Tarlac');
});
