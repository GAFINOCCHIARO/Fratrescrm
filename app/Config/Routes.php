<?php

use CodeIgniter\Router\RouteCollection;

/*
 * @var RouteCollection $routes
 */

$routes->setDefaultNamespace('App\Controllers');
$routes->get('/', 'Home::index');
$routes->get('Nuova_azienda', 'CompanyController::NewCompanyviews');
$routes->post('registercompany', 'CompanyController::InsertCompany');
$routes->post('Comuni/getComuni', 'ComuniController::getComuni');
$routes->group('', ['filter' => 'login'], static function ($routes) {
    // adimn
    $routes->get('gdpr', 'GdprController::index');
    $routes->post('GetComuni', 'ComuniController::getComuni');
    $routes->get('ForceResetPassword', 'AdminController::restpsw');
    $routes->post('SaveNewPassword', 'AdminController::SaveNewpassword', ['filter' => 'login:user.change_password']);
    $routes->post('UpdatePassword', 'AdminController::UpdatePassword', ['filter' => 'login:user.change_password']);
    $routes->post('Newpassword', 'AdminController::Newpassword', ['filter' => 'login:user.change_password']);

    $routes->get('AdimnHome', 'AdminController::index', ['filter' => 'login:admin.dashboardacces']);
    $routes->post('ActivateUser', 'AdminController::Activateuser', ['filter' => 'login:admin.activateuser']);
    $routes->post('EditUser', 'AdminController::EditUser', ['filter' => 'login:admin.edituser']);
    $routes->post('EditUserexsam', 'AdminController::EditUserexsam', ['filter' => 'login:admin.editexsam']);
    $routes->post('UpdateUser', 'AdminController::AdimnUpdateUser', ['filter' => 'login:admin.changedatauser']);
    $routes->post('NewUserView', 'AdminController::NewUserView', ['filter' => 'login:admin.newuserinsert']);
    $routes->post('SaveNewUser', 'AdminController::SaveNewUser', ['filter' => 'login:admin.newuserinsert']);
    $routes->post('UserDelete', 'AdminController::UserDelete', ['filter' => 'login:admin.userdelete']);
    $routes->post('UpdateUserUniqueCode', 'AdminController::UpdateUserUniqueCode', ['filter' => 'login:admin.mangagecaicode']);
    $routes->post('FindUserfromUniqueCode', 'AdminController::FindUserfromUniqueCode', ['filter' => 'login:admin.findfromcai']);
    $routes->post('Managereportview', 'AdminController::ManageReports', ['filter' => 'login:admin.findfromcai']);
    $routes->post('EditReport', 'AdminController::EditReport', ['filter' => 'login:admin.findfromcai']);
    $routes->post('movefile', 'AdminController::movefile', ['filter' => 'login:admin.findfromcai']);
    $routes->post('DelExsam', 'AdminController::DelExsam', ['filter' => 'login:admin.findfromcai']);
    $routes->post('DownloadReportAdmimarea', 'AdminController::DownloadReportAdmimarea', ['filter' => 'login:admin.downladreport']);
    $routes->post('uploadreferti', 'AdminController::Uploadfiles', ['filter' => 'login:admin.uploadfile']);
    $routes->post('sendmsg', 'AdminController::sendmsg', ['filter' => 'login:admin.infosendmessage']);
    $routes->get('no_permission', 'AdminController::noPermission', ['filter' => 'login']);
    $routes->post('show-update-level-view', 'AdminController::showUpdateLevelView', ['filter' => 'login:admin.level_up']);
    $routes->post('SaveLevelandGroup', 'AdminController::SaveLevelandGroup', ['filter' => 'login:admin.level_up']);
    $routes->post('editcompany', 'CompanyController::editCompanyprofile', ['filter' => 'login:admin.changecompanyprofile']);
    $routes->post('UpdateCompanydata', 'CompanyController::UpdateCompanydata', ['filter' => 'login:admin.changecompanyprofile']);
    $routes->post('ManageCalendar', 'appointments::ManageCalendar', ['filter' => 'login:admin.createappointments']);
    $routes->post('insertRepetitiveDays', 'appointments::insertRepetitiveDays', ['filter' => 'login:admin.createappointments']);
    $routes->post('addevent', 'Appointments::addevent', ['filter=>login:admin.createappointments']);
    $routes->post('delevent', 'Appointments::delevent', ['filter=>login:admin.createappointments']);
    $routes->post('appointmentdettail','Appointments::appointmentdettail',['filter'=>'login:admin.createappointments']);
    $routes->post('appointmentconfirm','Appointments::appointmentconfirm',['filter'=>'login:admin.createappointments']);
    $routes->get('prova','prova::index');
    // user
    $routes->get('Homeuser', 'UserController::index', ['filter=>login:user.homeaccess']);
    $routes->post('UpdateAvatarImage', 'UserController::updateAvatarimage', ['filter=>login:user.homeaccess']);
    $routes->post('Userappointment',   'UserController::Userappointment', ['filter=>login:user.homeaccess']);
    $routes->post('showtime',   'UserController::checkAvailability', ['filter=>login:user.homeaccess']);
    $routes->post('slot_time',   'UserController::slot_time', ['filter=>login:user.homeaccess']);
    $routes->post('saveappointment',   'UserController::saveappointment', ['filter=>login:user.homeaccess']);
});
// prove

service('auth')->routes($routes);
