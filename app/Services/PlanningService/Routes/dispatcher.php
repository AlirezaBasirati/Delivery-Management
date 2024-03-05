<?php

use App\Services\PlanningService\Controllers\V1\Common\ScheduleController;
use App\Services\PlanningService\Controllers\V1\Common\TemplateController;
use App\Services\PlanningService\Controllers\V1\Common\TemplateItemController;
use App\Services\PlanningService\Controllers\V1\Common\TimeslotController;
use Illuminate\Support\Facades\Route;

Route::middleware(['api', 'auth:api'])->prefix('api/dispatcher/v1')->name('dispatcher.')->group(function () {

    Route::patch('template_items/{templateItem}', [TemplateItemController::class, 'update']);
    Route::delete('template_items/{templateItem}', [TemplateItemController::class, 'destroy']);

    Route::get('templates/select', [TemplateController::class, 'select']);
    Route::apiResource('templates', TemplateController::class);

    Route::get('timeslots/select', [TimeslotController::class, 'select']);
    Route::apiResource('timeslots', TimeslotController::class);

    Route::post('schedules/{schedule}/assign-vehicles', [ScheduleController::class, 'assignVehicles']);
    Route::post('schedules/{schedule}/reserve', [ScheduleController::class, 'reserve'])->name('schedules.reserve');
    Route::get('schedules/calendar', [ScheduleController::class, 'calendar'])->name('schedules.calendar');
//    Route::get('schedules/calendar', function () {
//        return [
//            [
//                'date'         => '2024-01-01 00:00:00',
//                'day_of_week'  => 3,
//                'vehicle_type' => [
//                    'id'    => 1,
//                    'title' => 'موتور سیکلت'
//                ],
//                'plans'        => [
//                    [
//                        'timeslot'          => [
//                            'id'        => 1,
//                            'starts_at' => '08:00:00',
//                            'ends_at'   => '10:00:00'
//                        ],
//                        'capacity'          => 50,
//                        'used_capacity'     => 25,
//                        'reserved_capacity' => 0,
//                        'vehicles_count'    => 10
//                    ], [
//                        'timeslot'          => [
//                            'id'        => 2,
//                            'starts_at' => '10:00:00',
//                            'ends_at'   => '12:00:00'
//                        ],
//                        'capacity'          => 50,
//                        'used_capacity'     => 60,
//                        'reserved_capacity' => 0,
//                        'vehicles_count'    => 10
//                    ]
//                ]
//            ],
//            [
//                'date'         => '2024-01-02 00:00:00',
//                'day_of_week'  => 4,
//                'vehicle_type' => [
//                    'id'    => 1,
//                    'title' => 'موتور سیکلت'
//                ],
//                'plans'        => [
//                    [
//                        'timeslot'          => [
//                            'id'        => 1,
//                            'starts_at' => '08:00:00',
//                            'ends_at'   => '10:00:00'
//                        ],
//                        'capacity'          => 50,
//                        'used_capacity'     => 10,
//                        'reserved_capacity' => 50,
//                        'vehicles_count'    => 10
//                    ], [
//                        'timeslot'          => [
//                            'id'        => 2,
//                            'starts_at' => '10:00:00',
//                            'ends_at'   => '12:00:00'
//                        ],
//                        'capacity'          => 50,
//                        'used_capacity'     => 0,
//                        'reserved_capacity' => 50,
//                        'vehicles_count'    => 10
//                    ]
//                ]
//            ],
//            [
//                'date'         => '2024-01-03 00:00:00',
//                'day_of_week'  => 5,
//                'vehicle_type' => [
//                    'id'    => 1,
//                    'title' => 'موتور سیکلت'
//                ],
//                'plans'        => [
//                    [
//                        'timeslot'          => [
//                            'id'        => 1,
//                            'starts_at' => '08:00:00',
//                            'ends_at'   => '10:00:00'
//                        ],
//                        'capacity'          => 50,
//                        'used_capacity'     => 50,
//                        'reserved_capacity' => 50,
//                        'vehicles_count'    => 10
//                    ], [
//                        'timeslot'          => [
//                            'id'        => 2,
//                            'starts_at' => '10:00:00',
//                            'ends_at'   => '12:00:00'
//                        ],
//                        'capacity'          => 50,
//                        'used_capacity'     => 50,
//                        'reserved_capacity' => 50,
//                        'vehicles_count'    => 10
//                    ]
//                ]
//            ],
//            [
//                'date'         => '2024-01-10 00:00:00',
//                'day_of_week'  => 5,
//                'vehicle_type' => [
//                    'id'    => 1,
//                    'title' => 'موتور سیکلت'
//                ],
//                'plans'        => [
//                    [
//                        'timeslot'          => [
//                            'id'        => 1,
//                            'starts_at' => '08:00:00',
//                            'ends_at'   => '10:00:00'
//                        ],
//                        'capacity'          => 50,
//                        'used_capacity'     => 1,
//                        'reserved_capacity' => 6,
//                        'vehicles_count'    => 8
//                    ], [
//                        'timeslot'          => [
//                            'id'        => 2,
//                            'starts_at' => '10:00:00',
//                            'ends_at'   => '12:00:00'
//                        ],
//                        'capacity'          => 50,
//                        'used_capacity'     => 35,
//                        'reserved_capacity' => 5,
//                        'vehicles_count'    => 6
//                    ]
//                ]
//            ],
//        ];
//    });
    Route::post('schedules/planning', [ScheduleController::class, 'plan'])->name('schedules.planning');
    Route::apiResource('schedules', ScheduleController::class);

});

