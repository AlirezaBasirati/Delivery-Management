<?php

namespace App\Services\OrderService\Documents\V1\Admin;

use OpenApi\Annotations as OA;

/**
 * @OA\Post(
 *    path="/api/admin/v1/orders",
 *    tags={"Admin > Order"},
 *    summary="Store An Order",
 *    security={{"bearerAuth":{}}},
 *    @OA\RequestBody(required=true,
 *         @OA\MediaType(
 *             mediaType="application/json",
 *             @OA\Schema(required={},
 *                 example={
 *                     "code":"123456",
 *                     "parcel_value":20000000,
 *                     "type":"on_demand",
 *                     "schedule_id":1,
 *                     "cod_amount":100000000,
 *                     "package_quantity":2,
 *                     "priority":"high",
 *                     "items": {
 *                         {
 *                          "material_code":"654321",
 *                          "name":"پنیر لبنه 400 گرمی",
 *                          "quantity":2,
 *                          "size":"10,20,30",
 *                          "weight":20
 *                         }
 *                     },
 *                     "locations": {
 *                         {
 *                             "latitude":35.721221,
 *                             "longitude":51.371040,
 *                             "name":"فروشگاه اپادانا",
 *                             "address":"تهران - خیابان خرمشهر - نرسیده به دشتک - پلاک 52 - طبقه 2",
 *                             "phone":"09123654789",
 *                             "postal_code":"1234568790",
 *                             "type":"pick_up"
 *                         },
 *                         {
 *                             "latitude":35.73122,
 *                             "longitude":51.381040,
 *                             "name":"ریحانه حسینی",
 *                             "address":"تهران - سعادت اباد - بالاتر از میدان کاج - کوچه ی 7",
 *                             "phone":"09123654789",
 *                             "postal_code":"1234568790",
 *                             "type":"drop_off"
 *                         }
 *                     },
 *                     "permissions": {
 *                         "return":true,
 *                         "partial_return":true
 *                     }
 *                 }
 *             )
 *         )
 *    ),
 *    @OA\Response(
 *        response=200,
 *        description="OK"
 *    )
 * )
 *
 *
 * @OA\Get(
 *     path="/api/admin/v1/orders/{order}",
 *     tags={"Admin > Order"},
 *     summary="Show an Order",
 *     security={{"bearerAuth":{}}},
 *     @OA\Parameter(name="order", in="path", description="Order id", @OA\Schema(type="string")),
 *     @OA\Response(
 *         response=200,
 *         description="OK"
 *     )
 * )
 *
 * @OA\Get(
 *     path="/api/admin/v1/orders",
 *     tags={"Admin > Order"},
 *     summary="Show Orders List",
 *     security={{"bearerAuth":{}}},
 *     @OA\Parameter(name="created_from", in="query", description="created_from", @OA\Schema(type="string")),
 *     @OA\Parameter(name="created_to", in="query", description="created_to", @OA\Schema(type="string")),
 *     @OA\Parameter(name="search", in="query", description="search", @OA\Schema(type="string")),
 *     @OA\Parameter(name="state_id", in="query", description="state_id", @OA\Schema(type="integer")),
 *     @OA\Parameter(name="status_id", in="query", description="status_id", @OA\Schema(type="integer")),
 *     @OA\Response(
 *         response=200,
 *         description="OK"
 *     )
 * )
 *
 * @OA\Get(
 *     path="/api/admin/v1/orders/{order}/map",
 *     tags={"Admin > Order"},
 *     summary="Show Order on Map",
 *     security={{"bearerAuth":{}}},
 *     @OA\Parameter(name="order", in="path", description="Order id", @OA\Schema(type="string")),
 *     @OA\Response(
 *         response=200,
 *         description="OK"
 *     )
 * )
 *
 * @OA\Get(
 *     path="/api/admin/v1/orders/export",
 *     tags={"Admin > Order"},
 *     summary="Get Excel Export",
 *     security={{"bearerAuth":{}}},
 *     @OA\Parameter(name="ids[]", in="query", description="Order Ids", @OA\Schema(type="array", @OA\Items(type="string", example="99e33652-0a27-4059-888d-4d1fa007fc05"))),
 *     @OA\Parameter(name="columns[]", in="query", description="Columns", @OA\Schema(type="array", @OA\Items(type="string", example="id"))),
 *     @OA\Parameter(name="created_from", in="query", example="2023-01-01 00:00:00", description="created from", @OA\Schema(type="date")),
 *     @OA\Parameter(name="created_to", in="query", example="2024-01-01 00:00:00", description="created from", @OA\Schema(type="date")),
 *     @OA\Response(
 *         response=200,
 *         description="OK"
 *     )
 * )
 *
 * @OA\Get(
 *     path="/api/admin/v1/orders/count",
 *     tags={"Admin > Order"},
 *     summary="Get Orders count",
 *     security={{"bearerAuth":{}}},
 *     @OA\Response(
 *         response=200,
 *         description="OK"
 *     )
 * )
 *
 * @OA\Post(
 *       path="/api/admin/v1/orders/{order}/change-status",
 *       tags={"Admin > Order"},
 *       summary="Change Order Status",
 *       security={{"bearerAuth":{}}},
 *       @OA\Parameter(name="order", in="path", description="Order id", @OA\Schema(type="string")),
 *       @OA\Parameter(name="status_id", in="query", description="Status id", @OA\Schema(type="integer")),
 *       @OA\Response(
 *           response=200,
 *           description="OK"
 *       )
 *   )
 *
 *
 * @OA\Post(
 *       path="/api/admin/v1/orders/{order}/assign-driver/{driver}",
 *       tags={"Admin > Order"},
 *       summary="Assign a driver to order and Un Assign previous driver if exists.",
 *       security={{"bearerAuth":{}}},
 *       @OA\Parameter(name="order", in="path", description="Order id", @OA\Schema(type="string")),
 *       @OA\Parameter(name="driver", in="path", description="Driver id", @OA\Schema(type="integer")),
 *       @OA\RequestBody(required=true,
 *            @OA\MediaType(
 *                mediaType="application/json",
 *                @OA\Schema(required={},
 *                    example={
 *                        "static_message_id":1,
 *                        "is_old_driver_location":true,
 *                        "pick_up": {
 *                            "latitude":"37.123456",
 *                            "longitude":"51.321456",
 *                            "name":"نقطه ی جدید پیک اپ",
 *                            "address":"ادرس فعلی درایور قبلی",
 *                            "postal_code":"1236547890",
 *                            "phone":"09136551554",
 *                        }
 *                    }
 *                )
 *            )
 *       ),
 *       @OA\Response(
 *           response=200,
 *           description="OK"
 *       )
 *   )
 *
 *
 * @OA\Post(
 *       path="/api/admin/v1/orders/{order}/un-assign-driver",
 *       tags={"Admin > Order"},
 *       summary="Un Assign a driver from order and Broadcast Order to Drivers.",
 *       security={{"bearerAuth":{}}},
 *       @OA\Parameter(name="order", in="path", description="Order id", @OA\Schema(type="string")),
 *       @OA\RequestBody(required=true,
 *            @OA\MediaType(
 *                mediaType="application/json",
 *                @OA\Schema(required={},
 *                    example={
 *                        "static_message_id":1,
 *                        "is_old_driver_location":true,
 *                        "pick_up": {
 *                            "latitude":"37.123456",
 *                            "longitude":"51.321456",
 *                            "name":"نقطه ی جدید پیک اپ",
 *                            "address":"ادرس فعلی درایور قبلی",
 *                            "postal_code":"1236547890",
 *                            "phone":"09136551554",
 *                        }
 *                    }
 *                )
 *            )
 *       ),
 *       @OA\Response(
 *           response=200,
 *           description="OK"
 *       )
 *   )
 *
 *
 * @OA\Post(
 *       path="/api/admin/v1/orders/{order}/broadcast",
 *       tags={"Admin > Order"},
 *       summary="Broadcast Un Assigned Order to Drivers.",
 *       security={{"bearerAuth":{}}},
 *       @OA\Parameter(name="order", in="path", description="Order id", @OA\Schema(type="string")),
 *       @OA\RequestBody(required=true,
 *            @OA\MediaType(
 *                mediaType="application/json",
 *                @OA\Schema(required={},
 *                    example={
 *                        "is_old_driver_location":true,
 *                        "pick_up": {
 *                            "latitude":"37.123456",
 *                            "longitude":"51.321456",
 *                            "name":"نقطه ی جدید پیک اپ",
 *                            "address":"ادرس فعلی درایور قبلی",
 *                            "postal_code":"1236547890",
 *                            "phone":"09136551554",
 *                        }
 *                    }
 *                )
 *            )
 *       ),
 *       @OA\Response(
 *           response=200,
 *           description="OK"
 *       )
 *   )
 *
 *
 * @OA\Post(
 *      path="/api/admin/v1/orders/{order}/cancel",
 *      tags={"Admin > Order"},
 *      summary="Cancel an order",
 *      security={{"bearerAuth":{}}},
 *      @OA\Parameter(name="order", in="path", description="Order id", @OA\Schema(type="string")),
 *      @OA\Response(
 *          response=200,
 *          description="OK"
 *      )
 *  )
 *
 * @OA\Delete(
 *      path="/api/admin/v1/orders/{order}",
 *      tags={"Admin > Order"},
 *      summary="Delete Order by id",
 *      security={{"bearerAuth":{}}},
 *      @OA\Parameter(name="order", in="path", description="Order id", @OA\Schema(type="string")),
 *      @OA\Response(
 *          response=200,
 *          description="OK"
 *      )
 *  )
 *
 */
class Order
{

}
