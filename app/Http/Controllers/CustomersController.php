<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Customer;
use Validator;

class CustomersController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        try {
            $statusCode = 200;
            $customers = Customer::all()->take(100);
        } catch (Exception $e) {
            $statusCode = 400;
        } finally {
            return response()->json($customers, $statusCode);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(Request $request)
    {

        $validator = $this->createValidator($request);

        $response = array();
        $statusCode = 200;

        try {
            if ($validator->fails()) {
                $response = $validator->errors()->all();
                throw new \Exception('validation');
            }

            // insert into DB
            $customer = new Customer();
            $customer->name = $request->input('name');
            $customer->email = $request->input('email');
            $customer->address = $request->input('address');

            $customer->save();

            $response = $customer;
        } catch (Exception $e) {
            $statusCode = 400;
            $response = ['error' => $e->getMessage()];
        } finally {
            return response()->json($response, $statusCode);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        $response = array();

        try {
            $customer = $this->getCustomer($id);

            if (!empty($customer)) {
                $response = $customer;
                $statusCode = 200;
            } else {
                $response = ["error" => "Customer doesn`t exists"];
                $statusCode = 404;
            }
        } catch (Exception $e) {

            $statusCode = 500;
            $response = ["error" => "Internal error"];
        } finally {
            return response()->json($response, $statusCode);
        }
    }

    /**
     * Update the specified resource in storage.
     * NOTE: RFC 2616  WE return only status without body if success
     *
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        $response = array();

        $customer = $this->getCustomer($id);

        // check if exists
        if (empty($customer)) {
            $response = ["error" => "Customer doesn`t exists"];
            $statusCode = 404;
            return response()->json($response, $statusCode);
        }


        $response = array();
        $statusCode = 200;

        try {
            $validator = $this->createValidator($request, $customer);

            if ($validator->fails()) {
                $response = $validator->errors()->all();
                throw new \Exception('validation');
            }

            // update  DB

            $customer->name = $request->input('name', $customer->name);
            $customer->email = $request->input('email', $customer->email);
            $customer->address = $request->input('address', $customer->address);

            $customer->save();
        } catch (Exception $e) {

            $statusCode = 400;
            $response = ['error' => $e->getMessage()];
        } finally {
            return response()->json($response, $statusCode);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        $response = array();

        $customer = $this->getCustomer($id);

        // check if exists
        if (empty($customer)) {
            $response = ["error" => "Customer doesn`t exists"];
            $statusCode = 404;
            return response()->json($response, $statusCode);
        }

        // delete
        try {
            $customer->delete();
            $statusCode = 204;
        } catch (Exception $e) {
            $response = ["error" => "Internal server error"];
            $statusCode = 500;
        } finally {
            return response()->json($response, $statusCode);
        }
    }
    // ------------------------------------------------------------------------

    /**
     * Return validation rules depending on action
     * 
     * @param Request $request
     * @param Customers $customer
     * @return type
     */
    private function createValidator($request, $customer = false)
    {

        switch ($request->method()) {
            case 'POST':
                return Validator::make($request->all(), [
                        'email' => 'required|max:255|email|unique:customers',
                        'name' => 'required|max:255',
                        'address' => 'required|max:255',
                ]);

            case 'PUT':
                return Validator::make($request->all(), [
                        'email' => 'required|max:255|email|unique:customers,email,' . $customer->id,
                        'name' => 'required|max:255',
                        'address' => 'required|max:255',
                ]);

            case 'PATCH':
                return Validator::make($request->all(), [
                        'email' => 'max:255|email|unique:customers,email,' . $customer->id,
                        'name' => 'max:255',
                        'address' => 'max:255',
                ]);

            default:break;
        }
    }

    /**
     * Get customer by id
     * 
     * @param int $id
     * @return Customers
     */
    private function getCustomer($id)
    {
        try {
            $customer = Customer::find($id);
        } catch (Exception $e) {

            $statusCode = 500;
            $response = [
                "error" => "Internal error"
            ];
            return response()->json($response, $statusCode);
        }


        return $customer;
    }
}
