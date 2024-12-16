<?php

namespace App\Http\Controllers\Documentation;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

/**
 * @OA\Info(title="WiseFlow API Documentation", version="1.0")
 * 
 * @OA\SecurityScheme(
 *     securityScheme="Token",
 *     type="apiKey",
 *     in="header",
 *     name="Authorization",
 *     description="Bearer token used for authentication"
 * )
 */
class SwaggerController extends Controller
{
    /**
     * Get User Token
     * @OA\Post(
     *     path="/login",
     *     tags={"Authentication"},
     *     operationId="login",
     *     summary="Login to get Authentication Token",
     *     description="Mengambil Token User",
     *     @OA\Parameter(
     *         name="login",
     *         in="query",
     *         description="The Username / Email",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *         name="password",
     *         in="query",
     *         description="The Password",
     *         @OA\Schema(type="password")
     *     ),
     *     @OA\Response(
     *         response="200",
     *         description="Ok",
     *         @OA\JsonContent(
     *             example={
     *                 "success": true,
     *                 "message": "Berhasil mengambil data Property",
     *                 "token": "1-adsBASDMzxckopasdkpwqkiqwje"
     *             }
     *         ),
     *     ),
     * )
     * @OA\Post(
     *     path="/logout",
     *     tags={"Authentication"},
     *     operationId="logout",
     *     summary="Logout to reset Authentication Token",
     *     description="Mereset Token User",
     *     @OA\Response(
     *         response="200",
     *         description="Ok",
     *         @OA\JsonContent(
     *             example={
     *                 "success": true,
     *                 "message": "Berhasil logout",
     *             }
     *         ),
     *     ),
     * )
     * 
     * Property Documentation
     * @OA\Get(
     *     path="/api/property/byUserAll/{id}",
     *     tags={"Property"},
     *     operationId="PropertyGetUser",
     *     summary="Property Get All By Id User (Membutuhkan Role Admin)",
     *     description="Mengambil Data Property (Membutuhkan Role Admin)",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="The User Id",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response="200",
     *         description="Ok",
     *         @OA\JsonContent(
     *             example={
     *                 "success": true,
     *                 "message": "Berhasil mengambil data Property",
     *                 "data": {
     *                     {
     *                         "id_property": "1",
     *                         "id_user_owner": "1",
     *                         "property_name": "kontrakan",
     *                         "property_desc": "description kontrakan",
     *                         "property_bank": "1000",
     *                         "id_cover": "1",
     *                         "created_at": "10/10/2020",
     *                         "updated_at": "11/10/2022",
     *                     }
     *                 }
     *             }
     *         ),
     *     ),
     *     @OA\Response(
     *         response="403",
     *         description="Forbidden",
     *         @OA\JsonContent(
     *             example={
     *                 "success": false,
     *                 "message": "Unauthorized Permission"
     *             }
     *         )
     *     ),
     *     @OA\Response(
     *         response="401",
     *         description="Unauthorized",
     *         @OA\JsonContent(
     *             example={
     *                 "message": "Unauthenticated.",
     *             }
     *         ),
     *     ),
     *     security={
     *         {"bearerAuth": {}} 
     *     }
     * )
     * 
     * @OA\Get(
     *     path="/api/property",
     *     tags={"Property"},
     *     operationId="PropertyGetAll",
     *     summary="Property Get All (Membutuhkan Role Admin)",
     *     description="Mengambil Data Property (Membutuhkan Role Admin)",
     *     @OA\Response(
     *         response="200",
     *         description="Ok",
     *         @OA\JsonContent(
     *             example={
     *                 "success": true,
     *                 "message": "Berhasil mengambil data Property",
     *                 "data": {
     *                     {
     *                         "id_property": "1",
     *                         "id_user_owner": "1",
     *                         "property_name": "kontrakan",
     *                         "property_desc": "description kontrakan",
     *                         "property_bank": "1000",
     *                         "id_cover": "1",
     *                         "created_at": "10/10/2020",
     *                         "updated_at": "11/10/2022",
     *                     }
     *                 }
     *             }
     *         ),
     *     ),
     * )
     * 
     * @OA\Get(
     *     path="/api/property/{id}",
     *     tags={"Property"},
     *     operationId="PropertyGetId",
     *     summary="Property Get By Id",
     *     description="Mengambil Data Property Berdasarkan Id",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="The Property ID",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response="200",
     *         description="Ok",
     *         @OA\JsonContent(
     *             example={
     *                 "success": true,
     *                 "message": "Berhasil mengambil data Property",
     *                 "data": {
     *                     {
     *                         "id_property": "1",
     *                         "id_user_owner": "1",
     *                         "property_name": "kontrakan",
     *                         "property_desc": "description kontrakan",
     *                         "property_bank": "1000",
     *                         "id_cover": "1",
     *                         "created_at": "10/10/2020",
     *                         "updated_at": "11/10/2022",
     *                     }
     *                 }
     *             }
     *         ),
     *     ),
     * )
     * @OA\Post(
     *     path="/api/property",
     *     tags={"Property"},
     *     operationId="PropertyPost",
     *     summary="Property Create (Membutuhkan Permission permission-create)",
     *     description="Menambahkan Data Property (Membutuhkan Permission <b>permission-create</b>)",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"id_user_owner", "property_name", "property_desc", "property_bank", "id_cover"},
     *             @OA\Property(property="id_user_owner", type="integer", description="The user ID who owns the property"),
     *             @OA\Property(property="property_name", type="string", description="The name of the property"),
     *             @OA\Property(property="property_desc", type="string", description="A description of the property"),
     *             @OA\Property(property="property_bank", type="integer", description="The property's bank value or price"),
     *             @OA\Property(property="id_cover", type="integer", description="The cover image ID for the property")
     *         )
     *     ),
     *     @OA\Response(
     *         response="200",
     *         description="Ok",
     *         @OA\JsonContent(
     *             example={
     *                 "success": true,
     *                 "message": "Berhasil menambah data Property",
     *                 "data": {
     *                     "id_property": "1",
     *                     "id_user_owner": "1",
     *                     "property_name": "kontrakan",
     *                     "property_desc": "description kontrakan",
     *                     "property_bank": "1000",
     *                     "id_cover": "1",
     *                     "created_at": "10/10/2020",
     *                     "updated_at": "11/10/2022"
     *                 }
     *             }
     *         ),
     *     ),
     *     @OA\Response(
     *         response="400",
     *         description="Bad Request",
     *         @OA\JsonContent(
     *             example={
     *                 "success": false,
     *                 "message": "Validation errors"
     *             }
     *         )
     *     )
     * )
     * @OA\Put(
     *     path="/api/property/{id}",
     *     tags={"Property"},
     *     operationId="PropertyUpdate",
     *     summary="Property Update (Membutuhkan Permission permission-update)",
     *     description="Mengupdate Data Property (Membutuhkan Permission <b>permission-update</b>)",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="The Property ID",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"property_name", "property_desc", "property_bank", "id_cover"},
     *             @OA\Property(property="property_name", type="string", description="The name of the property"),
     *             @OA\Property(property="property_desc", type="string", description="A description of the property"),
     *             @OA\Property(property="property_bank", type="integer", description="The property's bank value or price"),
     *             @OA\Property(property="id_cover", type="integer", description="The cover image ID for the property")
     *         )
     *     ),
     *     @OA\Response(
     *         response="200",
     *         description="Ok",
     *         @OA\JsonContent(
     *             example={
     *                 "success": true,
     *                 "message": "Berhasil mengupdate data Property",
     *                 "data": {}
     *             }
     *         )
     *     )
     * )
     * @OA\Delete(
     *     path="/api/property/{id}",
     *     tags={"Property"},
     *     operationId="PropertyDelete",
     *     summary="Property Delete (Membutuhkan Permission permission-delete)",
     *     description="Menghapus Data Property (Membutuhkan Permission <b>permission-delete</b>)",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="The Property ID",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response="200",
     *         description="Ok",
     *         @OA\JsonContent(
     *             example={
     *                 "success": true,
     *                 "message": "Berhasil menghapus data Property"
     *             }
     *         )
     *     )
     * )
     * 
     * Contact Documentation
     * @OA\Get(
     *     path="/api/contact",
     *     tags={"Contact"},
     *     operationId="ContactGetAll",
     *     summary="Contact Get All",
     *     description="Mengambil Data Contact",
     *     @OA\Response(
     *         response="200",
     *         description="Ok",
     *         @OA\JsonContent(
     *             example={
     *                 "success": true,
     *                 "message": "Berhasil mengambil data Contact",
     *             }
     *         ),
     *     ),
     * )
     * 
     * @OA\Get(
     *     path="/api/contact/{id}",
     *     tags={"Contact"},
     *     operationId="ContactGetId",
     *     summary="Contact Get By Id",
     *     description="Mengambil Data Contact Berdasarkan Id",
     *     @OA\Response(
     *         response="200",
     *         description="Ok",
     *         @OA\JsonContent(
     *             example={
     *                 "success": true,
     *                 "message": "Berhasil mengambil data Contact",
     *                 "data": {
     *                     {
     *                         "id_contact": "1",
     *                         "id_user": "1",
     *                         "name": "John",
     *                         "email": "John@gmail.com",
     *                         "no_hp": "082912313",
     *                         "created_at": "10/10/2004",
     *                         "updated_at": "12/12/2024"
     *                     }
     *                 }
     *             }
     *         ),
     *     ),
     * )
     * 
     * @OA\Post(
     *     path="/api/contact",
     *     tags={"Contact"},
     *     operationId="ContactPost",
     *     summary="Contact Create",
     *     description="Membuat Data Contact",
     *     @OA\Response(
     *         response="200",
     *         description="Ok",
     *         @OA\JsonContent(
     *             example={
     *                 "success": true,
     *                 "message": "Berhasil menambah data Contact",
     *             }
     *         ),
     *     ),
     * )
     * @OA\Put(
     *     path="/api/contact/{id}",
     *     tags={"Contact"},
     *     operationId="ContactPut",
     *     summary="Contact Update",
     *     description="Mengupdate Data Contact",
     *     @OA\Response(
     *         response="200",
     *         description="Ok",
     *         @OA\JsonContent(
     *             example={
     *                 "success": true,
     *                 "message": "Berhasil mengupdate data Contact",
     *             }
     *         ),
     *     ),
     * )
     * @OA\Delete(
     *     path="/api/contact/{id}",
     *     tags={"Contact"},
     *     operationId="ContactDelete",
     *     summary="Contact Delete",
     *     description="Menghapus Data Contact",
     *     @OA\Response(
     *         response="200",
     *         description="Ok",
     *         @OA\JsonContent(
     *             example={
     *                 "success": true,
     *                 "message": "Berhasil menghapus data Contact",
     *             }
     *         ),
     *     ),
     * )
     * 
     * Iuran Documentation
     * @OA\Get(
     *     path="/api/iuran",
     *     tags={"Iuran"},
     *     operationId="IuranGetAll",
     *     summary="Iuran Get All",
     *     description="Mengambil Data Iuran",
     *     @OA\Response(
     *         response="200",
     *         description="Ok",
     *         @OA\JsonContent(
     *             example={
     *                 "success": true,
     *                 "message": "Berhasil mengambil data Iuran",
     *                 "data": {
     *                     {
     *                         "id_iuran": "1",
     *                         "id_property": "1",
     *                         "type_iuran": "Kebutuhan",
     *                         "nominal_iuran": "50000",
     *                         "tanggal_iuran": "10/10/2004",
     *                         "tenggat_iuran": "12/12/2024",
     *                         "created_at": "10/10/2004",
     *                         "updated_at": "12/12/2024"
     *                     }
     *                 }
     *             }
     *         ),
     *     ),
     * )
     * @OA\Get(
     *     path="/api/iuran/{id}",
     *     tags={"Iuran"},
     *     operationId="IuranGetId",
     *     summary="Iuran Get By Id",
     *     description="Mengambil Data Iuran Berdasarkan Id",
     *     @OA\Response(
     *         response="200",
     *         description="Ok",
     *         @OA\JsonContent(
     *             example={
     *                 "success": true,
     *                 "message": "Berhasil mengambil data Iuran",
     *                 "data": {
     *                     {
     *                         "id_iuran": "1",
     *                         "id_property": "1",
     *                         "type_iuran": "Kebutuhan",
     *                         "nominal_iuran": "50000",
     *                         "tanggal_iuran": "10/10/2004",
     *                         "tenggat_iuran": "12/12/2024",
     *                         "created_at": "10/10/2004",
     *                         "updated_at": "12/12/2024"
     *                     }
     *                 }
     *             }
     *         ),
     *     ),
     * )
     * 
     * @OA\Post(
     *     path="/api/iuran",
     *     tags={"Iuran"},
     *     operationId="IuranPost",
     *     summary="Iuran Create",
     *     description="Membuat Data Iuran",
     *     @OA\Response(
     *         response="200",
     *         description="Ok",
     *         @OA\JsonContent(
     *             example={
     *                 "success": true,
     *                 "message": "Berhasil menambah data Iuran",
     *             }
     *         ),
     *     ),
     * )
     * @OA\Put(
     *     path="/api/iuran/{id}",
     *     tags={"Iuran"},
     *     operationId="IuranPut",
     *     summary="Iuran Update",
     *     description="Mengupdate Data Iuran",
     *     @OA\Response(
     *         response="200",
     *         description="Ok",
     *         @OA\JsonContent(
     *             example={
     *                 "success": true,
     *                 "message": "Berhasil mengupdate data Iuran",
     *             }
     *         ),
     *     ),
     * )
     * @OA\Delete(
     *     path="/api/iuran/{id}",
     *     tags={"Iuran"},
     *     operationId="IuranDelete",
     *     summary="Iuran Delete",
     *     description="Menghapus Data Iuran",
     *     @OA\Response(
     *         response="200",
     *         description="Ok",
     *         @OA\JsonContent(
     *             example={
     *                 "success": true,
     *                 "message": "Berhasil menghapus data Iuran",
     *             }
     *         ),
     *     ),
     * )
     * 
     * Communication Documentation
     * @OA\Get(
     *     path="/api/communication",
     *     tags={"Communication"},
     *     operationId="CommunicationGetAll",
     *     summary="Communication Get All",
     *     description="Mengambil Data Communication",
     *     @OA\Response(
     *         response="200",
     *         description="Ok",
     *         @OA\JsonContent(
     *             example={
     *                 "success": true,
     *                 "message": "Berhasil mengambil data Communication",
     *                 "data": {
     *                     {
     *                         "id_com": "1",
     *                         "id_group": "1",
     *                         "id_user": "1",
     *                         "text": "Hallo World",
     *                         "created_at": "10/10/2004",
     *                         "updated_at": "12/12/2024"
     *                     }
     *                 }
     *             }
     *         ),
     *     ),
     * )
     * @OA\Get(
     *     path="/api/communication/{id}",
     *     tags={"Communication"},
     *     operationId="CommunicationGetId",
     *     summary="Communication Get By Id Communication",
     *     description="Mengambil Data Communication Berdasarkan Id Communication",
     *     @OA\Response(
     *         response="200",
     *         description="Ok",
     *         @OA\JsonContent(
     *             example={
     *                 "success": true,
     *                 "message": "Berhasil mengambil data Communication",
     *                 "data": {
     *                     {
     *                         "id_com": "1",
     *                         "id_group": "1",
     *                         "id_user": "1",
     *                         "text": "Hallo World",
     *                         "created_at": "10/10/2004",
     *                         "updated_at": "12/12/2024"
     *                     }
     *                 }
     *             }
     *         ),
     *     ),
     * )
     * @OA\Get(
     *     path="/api/communication/byUser/{id}",
     *     tags={"Communication"},
     *     operationId="CommunicationGetIdUser",
     *     summary="Communication Get By Id User",
     *     description="Mengambil Data Communication Berdasarkan Id User",
     *     @OA\Response(
     *         response="200",
     *         description="Ok",
     *         @OA\JsonContent(
     *             example={
     *                 "success": true,
     *                 "message": "Berhasil mengambil data Communication",
     *                 "data": {
     *                     {
     *                         "id_com": "1",
     *                         "id_group": "1",
     *                         "id_user": "1",
     *                         "text": "Hallo World",
     *                         "created_at": "10/10/2004",
     *                         "updated_at": "12/12/2024"
     *                     }
     *                 }
     *             }
     *         ),
     *     ),
     * )
     * @OA\Get(
     *     path="/api/communication/byGroup/{id}",
     *     tags={"Communication"},
     *     operationId="CommunicationGetGroup",
     *     summary="Communication Get By Id Group",
     *     description="Mengambil Data Communication Berdasarkan Id Group",
     *     @OA\Response(
     *         response="200",
     *         description="Ok",
     *         @OA\JsonContent(
     *             example={
     *                 "success": true,
     *                 "message": "Berhasil mengambil data Communication",
     *                 "data": {
     *                     {
     *                         "id_com": "1",
     *                         "id_group": "1",
     *                         "id_user": "1",
     *                         "text": "Hallo World",
     *                         "created_at": "10/10/2004",
     *                         "updated_at": "12/12/2024"
     *                     }
     *                 }
     *             }
     *         ),
     *     ),
     * )
     * 
     * @OA\Post(
     *     path="/api/communication",
     *     tags={"Communication"},
     *     operationId="CommunicationPost",
     *     summary="Communication Create",
     *     description="Membuat Data Communication",
     *     @OA\Response(
     *         response="200",
     *         description="Ok",
     *         @OA\JsonContent(
     *             example={
     *                 "success": true,
     *                 "message": "Berhasil menambah data Communication",
     *             }
     *         ),
     *     ),
     * )
     * @OA\Put(
     *     path="/api/communication/{id}",
     *     tags={"Communication"},
     *     operationId="CommunicationPut",
     *     summary="Communication Update",
     *     description="Mengupdate Data Communication",
     *     @OA\Response(
     *         response="200",
     *         description="Ok",
     *         @OA\JsonContent(
     *             example={
     *                 "success": true,
     *                 "message": "Berhasil mengupdate data Communication",
     *             }
     *         ),
     *     ),
     * )
     * @OA\Delete(
     *     path="/api/communication/{id}",
     *     tags={"Communication"},
     *     operationId="CommunicationDelete",
     *     summary="Communication Delete",
     *     description="Menghapus Data Communication",
     *     @OA\Response(
     *         response="200",
     *         description="Ok",
     *         @OA\JsonContent(
     *             example={
     *                 "success": true,
     *                 "message": "Berhasil menghapus data Communication",
     *             }
     *         ),
     *     ),
     * )
     * 
     * Rent Controller
     * @OA\Get(
     *     path="/api/rent",
     *     tags={"Rent"},
     *     operationId="RentGetAll",
     *     summary="Rent Get All",
     *     description="Mengambil Data Rent",
     *     @OA\Response(
     *         response="200",
     *         description="Ok",
     *         @OA\JsonContent(
     *             example={
     *                 "success": true,
     *                 "message": "Berhasil mengambil data Rent",
     *                 "data": {
     *                     {
     *                         "id_rent": "1",
     *                         "id_property": "1",
     *                         "rent_name": "Kamar 01",
     *                         "rent_description": "rent Descripiotn",
     *                         "stock": "100",
     *                         "availability": true,
     *                         "created_at": "10/10/2004",
     *                         "updated_at": "12/12/2024"
     *                     }
     *                 }
     *             }
     *         ),
     *     ),
     * )
     * @OA\Get(
     *     path="/api/rent/{id}",
     *     tags={"Rent"},
     *     operationId="RentGetById",
     *     summary="Rent Get By Id Rent",
     *     description="Mengambil Data Rent",
     *     @OA\Response(
     *         response="200",
     *         description="Ok",
     *         @OA\JsonContent(
     *             example={
     *                 "success": true,
     *                 "message": "Berhasil mengambil data Rent",
     *                 "data": {
     *                     {
     *                         "id_rent": "1",
     *                         "id_property": "1",
     *                         "rent_name": "Kamar 01",
     *                         "rent_description": "rent Descripiotn",
     *                         "stock": "100",
     *                         "availability": true,
     *                         "created_at": "10/10/2004",
     *                         "updated_at": "12/12/2024"
     *                     }
     *                 }
     *             }
     *         ),
     *     ),
     * )
     * @OA\Get(
     *     path="/api/rent/byProperty/{id}",
     *     tags={"Rent"},
     *     operationId="RentGetByProperty",
     *     summary="Rent Get By Id Property",
     *     description="Mengambil Data Rent",
     *     @OA\Response(
     *         response="200",
     *         description="Ok",
     *         @OA\JsonContent(
     *             example={
     *                 "success": true,
     *                 "message": "Berhasil mengambil data Rent",
     *                 "data": {
     *                     {
     *                         "id_rent": "1",
     *                         "id_property": "1",
     *                         "rent_name": "Kamar 01",
     *                         "rent_description": "rent Descripiotn",
     *                         "stock": "100",
     *                         "availability": true,
     *                         "created_at": "10/10/2004",
     *                         "updated_at": "12/12/2024"
     *                     }
     *                 }
     *             }
     *         ),
     *     ),
     * )
     * 
     * @OA\Post(
     *     path="/api/rent",
     *     tags={"Rent"},
     *     operationId="RentPost",
     *     summary="Rent Create",
     *     description="Membuat Data Rent",
     *     @OA\Response(
     *         response="200",
     *         description="Ok",
     *         @OA\JsonContent(
     *             example={
     *                 "success": true,
     *                 "message": "Berhasil menambah data Rent",
     *             }
     *         ),
     *     ),
     * )
     * @OA\Put(
     *     path="/api/rent/{id}",
     *     tags={"Rent"},
     *     operationId="RentPut",
     *     summary="Rent Update",
     *     description="Mengupdate Data Rent",
     *     @OA\Response(
     *         response="200",
     *         description="Ok",
     *         @OA\JsonContent(
     *             example={
     *                 "success": true,
     *                 "message": "Berhasil mengupdate data Rent",
     *             }
     *         ),
     *     ),
     * )
     * @OA\Delete(
     *     path="/api/rent/{id}",
     *     tags={"Rent"},
     *     operationId="RentDelete",
     *     summary="Rent Delete",
     *     description="Menghapus Data Rent",
     *     @OA\Response(
     *         response="200",
     *         description="Ok",
     *         @OA\JsonContent(
     *             example={
     *                 "success": true,
     *                 "message": "Berhasil menghapus data Rent",
     *             }
     *         ),
     *     ),
     * )
     */

    public function dummy()
    {
        return 'dummy';
    }
}
