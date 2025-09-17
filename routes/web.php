<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Illuminate\Support\Facades\Hash;

use App\Http\Controllers\Go\{
    BranchesController as Branches,
    EmployeesController as Employees,
    EmploymentsController as Employments,
    EmploymentAreasController as EmploymentAreas,
    EmploymentTitlesController as EmploymentTitles,
};

use App\Http\Controllers\{
    UsersController as Users,
    EquipmentsController as Equipments,
    EquipmentCategoriesController as EquipmentCategories,
    EquipmentBrandsController as EquipmentBrands,
    EquipmentModelsController as EquipmentModels,
    EquipmentFeaturesController as EquipmentFeatures,
    EquipmentFeatureOptionsController as EquipmentFeatureOptions,
    EquipmentAccessoriesController as EquipmentAccessories,
    EquipmentOwnersController as EquipmentOwners,
    PhoneLinesController as PhoneLines,
    PhoneLineModalitiesController as PhoneLineModalities,
    ResponsivesController as Responsives,
    ResponsiveEndingsController as ResponsiveEndings,
    ResponsiveEquipmentsController as ResponsiveEquipments,
    ReportsController as Reports
};


if( !function_exists('create_route_names') ){
    function create_route_names( $prefix, $scope = 'web'  ){

        if( $scope == 'api' ){
            return [
                'index' => "$prefix",
                'show' => "$prefix.show",
                'store' => "$prefix.store",
                'update' => "$prefix.update",
                'destroy' => "$prefix.destroy",
            ];
        }
        else if( $scope == 'web' ){
            return [
                'index' => "$prefix",
                'create' => "$prefix.create",
                'show' => "$prefix.show",
                'edit' => "$prefix.edit",
                'store' => "$prefix.store",
                'update' => "$prefix.update",
                'destroy' => "$prefix.destroy",
            ];
        }
        else {
            return [];
        }

    }

}

// Route::get('/', function () {
//     return Inertia::render('Welcome', [
//         'canLogin' => Route::has('login'),
//         'canRegister' => Route::has('register'),
//         'laravelVersion' => Application::VERSION,
//         'phpVersion' => PHP_VERSION,
//     ]);
// });

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {

    Route::get('/', function () {
        return Inertia::render('Dashboard');
    });


    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');


    Route::get('/go', function () {
        $data = array();
        $data['data'] = [
            ['title' => 'Empleados', 'description' => 'Empleados de la Empresa', 'url' => '/go/employees'],
            ['title' => 'Plantas', 'description' => 'Plantas de la Empresa', 'url' => '/go/branches'],
            ['title' => 'Areas', 'description' => 'Areas de la Empresa', 'url' => '/go/employment-areas'],
            ['title' => 'Puestos', 'description' => 'Puestos de la Empresa', 'url' => '/go/employment-titles'],
        ];
        return Inertia::render('Go/Index', $data);
    })->name('go');


    Route::resource('/equipment-responsives', Equipments::class, [
        'names' => create_route_names( 'equipment-responsives' )
    ]);


    Route::get('/equipments/datatable', [Equipments::class, 'datatable'] )->name('equipments.datatable');
    Route::resource('/equipments', Equipments::class, [
        'names' => create_route_names( 'equipments' )
    ]);


    Route::resource('/responsives/{responsive_id}/equipments', ResponsiveEquipments::class, [
        'names' => create_route_names( 'responsives.equipments' )
    ]);
    Route::put('/responsives/{responsive_id}/equipments/{id}/create-promissory-note', [ResponsiveEquipments::class, 'create_promissory_note'] )->name('responsives.equipments.create-promissory-note');
    Route::get('/responsives/{responsive_id}/equipments/{id}/print-promissory-note', [ResponsiveEquipments::class, 'print_promissory_note'] )->name('responsives.equipments.print-promissory-note');
    Route::get('/responsives/{responsive_id}/equipments/{id}/download-promissory-note', [ResponsiveEquipments::class, 'download_promissory_note'] )->name('responsives.equipments.download-promissory-note');

    Route::put('/responsives/{responsive_id}/equipments/{id}/{id_phone}/{new_phone_id}/create-phone-line', [ResponsiveEquipments::class, 'update_phone_line'] )->name('responsives.equipments.create-phone-line');

    Route::get('/responsives/datatable', [Responsives::class, 'datatable'] )->name('responsives.datatable');
    Route::resource('/responsives', Responsives::class, [
        'names' => create_route_names( 'responsives' )
    ]);

    Route::put('/responsives/{id}/finalize', [Responsives::class, 'finalize'] )->name('responsives.finalize');
    Route::get('/responsives/{id}/print', [Responsives::class, 'print'] )->name('responsives.print');
    Route::get('/responsives/{id}/download', [Responsives::class, 'download'] )->name('responsives.download');

    Route::resource('/responsive-endings', ResponsiveEndings::class, [
        'names' => create_route_names( 'responsive-endings' )
    ]);



    Route::resource('/equipment-features', EquipmentFeatures::class, [
        'names' => create_route_names( 'equipment-features' )
    ]);
    Route::resource('/equipment-features/{id}/options', EquipmentFeatureOptions::class, [
        'names' => create_route_names( 'equipment-features.options' )
    ]);


    Route::resource('/equipment-accessories', EquipmentAccessories::class, [
        'names' => create_route_names( 'equipment-accessories' )
    ]);


    Route::resource('/phone-lines', PhoneLines::class, [
        'names' => create_route_names( 'phone-lines' )
    ]);
    Route::resource('/phone-line-modalities', PhoneLineModalities::class, [
        'names' => create_route_names( 'phone-line-modalities' )
    ]);



    Route::resource('/equipment-categories', EquipmentCategories::class, [
        'names' => create_route_names( 'equipment-categories' )
    ]);
    Route::resource('/equipment-models', EquipmentModels::class, [
        'names' => create_route_names( 'equipment-models' )
    ]);
    Route::resource('/equipment-brands', EquipmentBrands::class, [
        'names' => create_route_names( 'equipment-brands' )
    ]);

    Route::resource('/equipment-owners', EquipmentOwners::class, [
        'names' => create_route_names( 'equipment-owners' )
    ]);

    Route::resource('/users', Users::class, [
        'names' => create_route_names( 'users' )
    ]);

    Route::get('/reports', [Reports::class, 'index'] )->name('reports');
    Route::get('/reports/users', [Reports::class, 'users'] )->name('reports.users');
    Route::get('/reports/employees', [Reports::class, 'employees'] )->name('reports.employees');
    Route::get('/reports/equipments', [Reports::class, 'equipments'] )->name('reports.equipments');
    Route::get('/reports/phonelines', [Reports::class, 'phonelines'] )->name('reports.phonelines');
    Route::get('/reports/responsives', [Reports::class, 'responsives'] )->name('reports.responsives');


    Route::resource('go/employees', Employees::class, [
        'names' => create_route_names( 'employees' )
    ]);
    Route::resource('/go/branches', Branches::class, [
        'names' => create_route_names( 'branches' )
    ]);
    Route::resource('/go/employment-areas', EmploymentAreas::class, [
        'names' => create_route_names( 'employment-areas' )
    ]);
    Route::resource('/go/employment-titles', EmploymentTitles::class, [
        'names' => create_route_names( 'employment-titles' )
    ]);

    Route::put('/go/employees/{employee}/update', [Employments::class, 'update'])->name('employees.update');

    Route::resource('go/employees/{id}/employments', Employments::class, [
        'names' => create_route_names( 'employees.employments' )
    ]);


});

Route::get('/password/{password}', function( $password ){
    echo Hash::make( $password );
});

