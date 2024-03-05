<?php

namespace App\Services\OrderService\Documents\V1\Tenant;

use OpenApi\Annotations as OA;

/**
 * @OA\Get(
 *      path="/api/tenant/v1/orders/{order}",
 *      tags={"Tenant > Order"},
 *      summary="Show an Order",
 *      security={{"bearerAuth":{}}},
 *      @OA\Parameter(name="order", in="path", description="Order id", @OA\Schema(type="string")),
 *      @OA\Response(
 *          response=200,
 *          description="OK"
 *      )
 *  )
 *
 * @OA\Post(
 *    path="/api/tenant/v1/orders",
 *    tags={"Tenant > Order"},
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
 *                             "first_name":"فروشگاه",
 *                             "last_name":"اپادانا",
 *                             "address":"تهران - خیابان خرمشهر - نرسیده به دشتک - پلاک 52 - طبقه 2",
 *                             "building_number":8,
 *                             "unit":1,
 *                             "phone":"09123654789",
 *                             "email":"apadana@gmail.com",
 *                             "postal_code":"1234568790",
 *                             "type":"pick_up"
 *                         },
 *                         {
 *                             "latitude":35.73122,
 *                             "longitude":51.381040,
 *                             "name":"ریحانه حسینی",
 *                             "first_name":"ریحانه",
 *                             "last_name":"حسینی",
 *                             "address":"تهران - سعادت اباد - بالاتر از میدان کاج - کوچه ی 7",
 *                             "building_number":8,
 *                             "unit":1,
 *                             "phone":"09123654789",
 *                             "email":"reyhaneh@gmail.com",
 *                             "postal_code":"1234568790",
 *                             "type":"drop_off"
 *                         }
 *                     },
 *                     "customer": {
 *                         "first_name":"ریحانه",
 *                         "last_name":"حسینی",
 *                         "mobile":"09901849202"
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
 * @OA\Post(
 *      path="/api/tenant/v1/orders/{code}/cancel",
 *      tags={"Tenant > Order"},
 *      summary="Cancel an order",
 *      security={{"bearerAuth":{}}},
 *      @OA\Parameter(name="code", in="path", description="Order id", @OA\Schema(type="string")),
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
