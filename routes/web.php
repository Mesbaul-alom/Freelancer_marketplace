<?php
use Illuminate\Support\Facades\Route;
use App\Events\Message;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get('/', function () {
return view('marketplace');
});
Route::get('/send-message', function (Request $req) {
    event(new Message(
        $req->input('username'),
        $req->input('message') 
    ));

});
Route::get('/login', 'LoginController@index');
Route::post('/login', 'LoginController@verify');
Route::get('/logout', 'LogoutController@index');
Route::get('/register','RegistrationController@index');
Route::post('/register', 'RegistrationController@verify');
Route::group(['middleware'=>['sess']] , function(){
Route::group(['middleware'=>['type']] , function(){
Route::resource('/admin', 'AdminController');
Route::get('/Admin/dashboard', 'AdminController@dashboard')->name('admin.dashboard');
Route::get('/Admin/profile/', 'AdminController@profile')->name('admin.profile');
Route::post('/Admin/profile', 'AdminController@profile_update')->name('admin.update');
Route::get('/create/manager', 'AdminController@create')->name('admin.create');
Route::post('/create/manager', 'AdminController@submit')->name('admin.submit');
Route::get('/project/list', 'AdminController@projectlist')->name('admin.projectlist');
Route::get('/Admin/project/list/{id}', 'AdminController@projectlist_details')->name('Admin.projectlist_details');
Route::get('/Admin/project/delete/{id}', 'AdminController@delete_project')->name('Admin.delete_project');
Route::post('/Admin/project/delete/{id}', 'AdminController@destroy_project')->name('Admin.destroy_project');
Route::get('/contest/list', 'AdminController@contestlist')->name('admin.contestlist');
Route::get('/Admin/contest/list/{id}', 'AdminController@contestlist_details')->name('Admin.contestlist_details');
Route::get('/Admin/contest/delete/{id}', 'AdminController@delete_contest')->name('Admin.delete_contest');
Route::post('/Admin/contest/delete/{id}', 'AdminController@destroy_contest')->name('Admin.destroy_contest');
Route::get('/Admin/usersPending', 'AdminController@usersPending')->name('admin.usersPending');
Route::get('/user/approve/{id}', 'AdminController@usersapprove')->name('admin.usersapprove');
Route::get('/Admin/create/notice', 'AdminController@notice')->name('admin.notice');
Route::post('/Admin/create/notice', 'AdminController@notice_store')->name('admin.notice_store');
Route::get('/notice/delete/{id}', 'AdminController@notice_delete')->name('admin.notice_delete');
Route::get('/Admin/payment', 'AdminController@payment')->name('admin.payment');
Route::get('/Admin/sellerlist', 'AdminController@sellerlist')->name('admin.sellerlist');
Route::get('/Admin/buyerlist', 'AdminController@buyerlist')->name('admin.buyerlist');
Route::get('/Admin/managerlist', 'AdminController@managerlist')->name('admin.managerlist');
Route::get('/Manager/details/{id}', 'AdminController@managerdetails')->name('admin.userDetails');
Route::get('/Buyer/details/{id}', 'AdminController@buyerdetails')->name('admin.buyerdetails');
Route::get('/Seller/details/{id}', 'AdminController@sellerdetails')->name('admin.managerdetails');
Route::get('/suspend/{id}', 'AdminController@suspend')->name('admin.suspend');
Route::get('/active/{id}', 'AdminController@active')->name('admin.active');
Route::get('/delete/{id}', 'AdminController@destroy')->name('admin.delete');
Route::get('/download/{file}','AdminController@download');
Route::get('/total_users','AdminController@total_users');
Route::get('/pdf','AdminController@pdf');
Route::get('/Admin/application','AdminController@application')->name('admin.application');
Route::get('/Admin/create_blog', 'AdminController@create_blog')->name('admin.create_blog');
Route::post('/Admin/create_blog', 'AdminController@blog_store')->name('admin.blog_store');
Route::get('/blog/details/{id}', 'AdminController@blog_details')->name('admin.blog_details');
Route::post('/blog/details/{id}', 'AdminController@blog_update')->name('admin.blog_update');
Route::get('/blog/delete/{id}', 'AdminController@blog_detete')->name('admin.blog_detete');
Route::get('/chart', 'AdminController@chart')->name('admin.chart');
Route::get('/live_search', 'LiveSearchController@index');
Route::get('/live_search/action', 'LiveSearchController@action')->name('live_search.action');
});
Route::group(['middleware'=>['type2']] , function(){
Route::resource('/manager', 'ManagerController');
Route::get('/Manager/dashboard', 'ManagerController@dashboard')->name('Manager.dashboard');
Route::get('/Manager/profile', 'ManagerController@profile')->name('Manager.profile');
Route::get('/Manager/project/list', 'ManagerController@projectlist')->name('Manager.projectlist');
Route::get('/Manager/project/list/{id}', 'ManagerController@projectlist_details')->name('Manager.projectlist_details');
Route::get('/Manager/project/delete/{id}', 'ManagerController@delete_project')->name('Manager.delete_project');
Route::post('/Manager/project/delete/{id}', 'ManagerController@destroy_project')->name('Manager.destroy_project');
Route::get('/Manager/contest/list', 'ManagerController@contestlist')->name('Manager.contestlist');
Route::get('/Manager/contest/list/{id}', 'ManagerController@contestlist_details')->name('Manager.contestlist_details');
Route::get('/Manager/contest/delete/{id}', 'ManagerController@delete_contest')->name('Manager.delete_contest');
Route::post('/Manager/contest/delete/{id}', 'ManagerController@destroy_contest')->name('Manager.destroy_contest');
Route::get('/Manager/payment', 'ManagerController@payment')->name('Manager.payment');
Route::get('/Manager/sellerlist', 'ManagerController@sellerlist')->name('Manager.sellerlist');
Route::get('/Manager/buyerlist', 'ManagerController@buyerlist')->name('Manager.buyerlist');
Route::get('/download/{file}','ManagerController@download');
});
Route::group(['middleware'=>['type3']] , function(){
Route::resource('/buyer', 'BuyerController');
Route::get('/Buyer/dashboard', 'BuyerController@dashboard')->name('buyer.dashboard');
Route::get('/Buyer/profile', 'BuyerController@profile')->name('buyer.profile');
Route::get('/Buyer/bidList', 'BuyerController@bidList')->name('buyer.bidList');
Route::get('/bidlist/details/{id}', 'BuyerController@bidlist_details')->name('buyer.bidlist_details');
Route::get('/bidlist/seller_bidingproject/{id}', 'BuyerController@seller_bidingproject')->name('buyer.seller_bidingproject');
Route::get('/Buyer/contestList', 'BuyerController@contestList')->name('buyer.contestList');
Route::get('/contestList/details/{id}', 'BuyerController@contestlist_details')->name('buyer.contestlist_details');
Route::get('/Buyer/postProject', 'BuyerController@postProject')->name('buyer.postProject');
Route::post('/Buyer/postProject', 'BuyerController@store_project')->name('buyer.store_project');
Route::get('/postProject/details/{id}', 'BuyerController@postproject_details')->name('buyer.postproject_details');
Route::get('/postProject/edit/{id}', 'BuyerController@postproject_edit')->name('buyer.postproject_edit');
Route::post('/postProject/edit/{id}', 'BuyerController@postproject_update')->name('buyer.postproject_update');
Route::get('/Buyer/postContest', 'BuyerController@postContest')->name('buyer.postContest');
Route::post('/Buyer/postContest', 'BuyerController@store_contest')->name('buyer.store_project');
Route::get('/postContest/details/{id}', 'BuyerController@postcontest_details')->name('buyer.postcontest_details');
Route::get('/postContest/edit/{id}', 'BuyerController@postcontest_edit')->name('buyer.postcontest_edit');
Route::post('/postContest/edit/{id}', 'BuyerController@postcontest_update')->name('buyer.postcontest_update');
Route::get('/download/{file}','BuyerController@download');



});
Route::group(['middleware'=>['type4']] , function(){
Route::get('/sellerHome', 'HomeController@index')->middleware('sess');
        Route::get('/profile', 'HomeController@profile')->name('user.profile');
        Route::get('/profile/{id}','HomeController@update');
        Route::get('/protfolio', 'HomeController@protfolio');
        Route::post('/protfolio', 'HomeController@store');
        Route::get('/protfolio/details/{id}', 'HomeController@p_details');
        Route::get('/project', 'HomeController@project');
        Route::get('/myproject', 'HomeController@myproject');
        Route::get('/withdraw', 'HomeController@withdraw');
        Route::get('/project', 'HomeController@project');
    
        Route::get('/contest', 'HomeController@contest');
        Route::get('/dashboard', 'HomeController@dashboard');

//
       Route::get("product",'HomeController@dex');
       Route::get("detail/{id}",'HomeController@detail');
       Route::get("search",'HomeController@search');
       Route::post("add_to_cart",'HomeController@addToCart');

});
});
