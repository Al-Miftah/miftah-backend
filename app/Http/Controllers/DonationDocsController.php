<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DonationDocsController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $menus = [
            [
                'name' => 'Organizations',
                'page' => 'organizations',
                'children' => [
                    
                    ['method' => 'POST', 'title' => 'Create', 'page' => 'create'],
                    ['method' => 'GET', 'title' => 'Update', 'page' => 'update'],
                    ['method' => 'GET', 'title' => 'View', 'page' => 'view'],
                    ['method' => 'GET', 'title' => 'List', 'page' => 'list'],
                    ['method' => 'DELETE', 'title' => 'Delete', 'page' => 'delete'],
                    ['method' => 'GET', 'title' => 'List admins', 'page' => 'list-admins'],
                    ['method' => 'POST', 'title' => 'Add admin(s)', 'page' => 'add-admins'],
                    ['method' => 'DELETE', 'title' => 'Remove admin(s)', 'page' => 'remove-admins'],
                    ['method' => 'GET', 'title' => 'List donations', 'page' => 'list-donations'],
                    ['method' => 'GET', 'title' => 'View statistics', 'page' => 'view-statistics'],
                ]
            ],
            [
                'name' => 'Donations',
                'page' => 'donations',
                'children' => [
                    
                    ['method' => 'POST', 'title' => 'Create', 'page' => 'create'],
                    ['method' => 'GET', 'title' => 'Update', 'page' => 'update'],
                    ['method' => 'GET', 'title' => 'View', 'page' => 'view'],
                    ['method' => 'DELETE', 'title' => 'Delete', 'page' => 'delete'],
                    ['method' => 'GET', 'title' => 'List', 'page' => 'list']
                ]
            ],
            [
                'name' => 'Paystack',
                'page' => 'paystack',
                'children' => [
                    ['method' => 'GET', 'title' => 'Checkout', 'page' => 'checkout'],
                ]
            ]
        ];
        $page = $request->query('page') ?? 'welcome';        
        return view('docs.pages.'.$page, compact('menus'));
    }
}
