<?php

use Illuminate\Support\Facades\Route;

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

/*
|--------------------------------------------------------------------------
| Landing Page View Route
|--------------------------------------------------------------------------
*/

Route::view('/', 'welcome')->name('welcome');

/*
|--------------------------------------------------------------------------
| Authentication Routes
|--------------------------------------------------------------------------
*/

Auth::routes(['register' => false, 'verify' => false]);

/*
|--------------------------------------------------------------------------
| All User Type Profile Routes
|--------------------------------------------------------------------------
*/

// CALENDAR
// The staff calendar index.
Route::resource('/profile/profile-calendar', App\Http\Controllers\Profile\Calendar\CalendarController::class)->only('index', 'create');
// Profile events management.
Route::resource('/profile/profile-events', App\Http\Controllers\Profile\Calendar\EventController::class);
// Profile notes management.
Route::resource('/profile/profile-event-notes', App\Http\Controllers\Profile\Calendar\EventNoteController::class)->only('index', 'store');
// Outstanding Profile Invoices.
Route::get('/profile/profile-pending-jobs-dt', [App\Http\Controllers\Profile\Calendar\PendingJobsDatatableController::class, 'create'])->name('profile-pending-jobs-dt.create');


// INVOICES
// Outstanding Profile Invoices.
Route::resource('/profile/profile-invoices', App\Http\Controllers\Profile\Invoice\InvoiceController::class)->except('edit', 'update');
// Outstanding Profile Invoices.
Route::get('/profile/profile-invoices-dt', [App\Http\Controllers\Profile\Invoice\NewInvoiceDatatable::class, 'create'])->name('profile-invoices-dt.create');
// Paid Profile Invoices.
Route::resource('/profile/profile-paid-invoices', App\Http\Controllers\Profile\Invoice\PaidInvoiceController::class);
// Profile Invoices Download as PDF.
Route::resource('/profile/profile-invoices-download', App\Http\Controllers\Profile\Invoice\DownloadInvoiceController::class)->only('create');

// JOBS
// Invoice Change Finalised Status
Route::resource('/profile/profile-invoice-finalise', App\Http\Controllers\Profile\Job\FinaliseInvoiceController::class)->only('update');
// Invoice Change Submission Status
Route::resource('/profile/profile-invoice-submit', App\Http\Controllers\Profile\Job\SubmitInvoiceController::class)->only('update');
// Job Completed Image Upload Route
Route::resource('/profile/profile-job-completed', App\Http\Controllers\Profile\Job\JobCompletedController::class);
// Invoice Items
Route::resource('/profile/profile-job-invoice-item', App\Http\Controllers\Profile\Job\JobInvoiceItemController::class);
// Invoice A Job
Route::resource('/profile/profile-job-invoice', App\Http\Controllers\Profile\Job\JobInvoiceController::class)->only('index');
// Group Invoices from the view of a tradesperson
Route::resource('/profile/profile-group-invoice', App\Http\Controllers\Profile\Invoice\GroupInvoiceController::class);
// Group Invoices from the view of a tradesperson
Route::get('/profile/profile-group-invoice-dt',[App\Http\Controllers\Profile\Invoice\GroupInvoiceDatatableController::class, 'create'])->name('profile-group-invoice-dt.create');
// Tradespersons
Route::resource('/profile/profile-job-rates', App\Http\Controllers\Profile\Job\ViewRateController::class);
// Tradespersons
Route::resource('/profile/profile-job-measurements', App\Http\Controllers\Profile\Job\ViewJobMeasurementsController::class)->only('create', 'show');
// Tradesperson Job image upload 
Route::resource('/profile/profile-image-upload', App\Http\Controllers\Profile\Job\ImageUploadController::class);
// Job Customer Notes
Route::resource('/profile/profile-job-customer-notes', App\Http\Controllers\Profile\Job\CustomerNoteController::class);
// Jobs Customer Note Reply Route
Route::resource('/profile/profile-job-customer-note-r', App\Http\Controllers\Profile\Job\CustomerNoteResponseController::class)->only('store');
// Job Internal Notes
Route::resource('/profile/profile-job-internal-notes', App\Http\Controllers\Profile\Job\InternalNoteController::class);
// Job Internal Note Reply Route
Route::resource('/profile/profile-job-internal-note-r', App\Http\Controllers\Profile\Job\InternalNoteResponseController::class)->only('store');
// Tradesperson View And Update SWMS
Route::resource('/profile/profile-jobs-swms', App\Http\Controllers\Profile\Job\SwmsController::class);
// Tradespersons View Of Job
Route::resource('/profile/profile-jobs', App\Http\Controllers\Profile\Job\JobController::class);
// Tradespersons View Of Job
Route::resource('/profile/profile-old-jobs', App\Http\Controllers\Profile\Job\ViewCompletedJobsController::class)->only('index', 'create', 'show');
// Tradesperson Update Job Progress
Route::resource('/profile/profile-update-job-progress', App\Http\Controllers\Profile\Job\UpdateJobProgressStatusController::class)->only('update');
// Send Job Update Email.
Route::resource('/profile/job-send-update-email', App\Http\Controllers\Profile\Job\SendJobUpdateEmailController::class);
// Tradesperson Download Pre-Receipt.
Route::resource('/profile/download-pre-receipt', App\Http\Controllers\Profile\Job\DownloadPreReceiptController::class);
// Tradesperson Take Card Payment From Customer.
Route::resource('/profile/tradesperson-accept-card-payment', App\Http\Controllers\Profile\Job\AcceptCardPaymentController::class);

// MESSAGES
// Create New Messages
Route::resource('/profile/profile-create-new-message', App\Http\Controllers\Profile\Message\CreateNewMessageController::class)->only('create', 'store');
// Inbox Datatable Route
Route::get('/profile/profile-messages-dt', [App\Http\Controllers\Profile\Message\InboxDatatableController::class, 'create'])->name('profile-messages-dt.create');
// Inbox Route
Route::resource('/profile/profile-messages', App\Http\Controllers\Profile\Message\MessageController::class);
// Sent Datatable Route
Route::get('/profile/profile-messages-sent-dt', [App\Http\Controllers\Profile\Message\SentDatatableController::class, 'create'])->name('profile-messages-sent-dt.create');
// Mark All User Profile Messages As Read
Route::resource('/profile/profile-messages-read-all', App\Http\Controllers\Profile\Message\MarkAllAsReadController::class)->only('update');
// Delete All User Profile Messages
Route::resource('/profile/profile-messages-delete-all', App\Http\Controllers\Profile\Message\DeleteAllController::class)->only('destroy');
// Message Replies
Route::resource('/profile/profile-messages-reply', App\Http\Controllers\Profile\Message\ResponseController::class)->only('store');

// NOTES
// Profile Notes Inbox
Route::resource('/profile/profile-notes', App\Http\Controllers\Profile\Note\InboxController::class);
// Profile Notes Inbox
Route::resource('/profile/profile-notes-acknowledged-dt', App\Http\Controllers\Profile\Note\AcknowledgedDatatableController::class);
// Profile Note Responses
Route::resource('/profile/profile-note-responses', App\Http\Controllers\Profile\Note\NoteResponseController::class)->only('store');
// Profile Note Mark As Read.
Route::resource('/profile/profile-note-mark-as-read', App\Http\Controllers\Profile\Note\NoteMarkAsReadController::class)->only('update');

// EXTRAS
// Financial Details
Route::resource('/profile/profile-financial-details', App\Http\Controllers\Profile\Financial\FinancialController::class)->only('index', 'show');
// Qualifications
Route::resource('/profile/profile-qualifications', App\Http\Controllers\Profile\Qualification\QualificationController::class)->only('index', 'show');
// Testimonials
Route::resource('/profile/profile-testimonials', App\Http\Controllers\Profile\Testimonial\TestimonialController::class)->only('index', 'show');

// INDEX
// The profile index.
Route::resource('/profile', App\Http\Controllers\Profile\ProfileController::class)->only('index');

/*
|--------------------------------------------------------------------------
| Application Main Menu Routes
|--------------------------------------------------------------------------
*/

// Menu Quick Customer Search
Route::post('/menu/menu-customer-search', [App\Http\Controllers\Menu\CustomerSearchController::class, 'index'])->name('menu.customer.search');
// Menu Quick Job Search
Route::post('/menu/menu-job-search', [App\Http\Controllers\Menu\JobSearchController::class, 'index'])->name('menu.job.search');
// Menu Quick Quote Search
Route::post('/menu/quick-quote-search', [App\Http\Controllers\Menu\QuoteSearchController::class, 'index'])->name('menu.quote.search');
// Main Menu Route
Route::resource('main-menu', App\Http\Controllers\Menu\MenuController::class)->only('index');

/*
|--------------------------------------------------------------------------
| Manage Customers Routes
|--------------------------------------------------------------------------
*/

// Customer Convert Lead To Customer
Route::resource('/customers/convert-lead-to-customer', App\Http\Controllers\Menu\Customer\ConvertLeadToCustomerController::class)->only('store');
// Manually update customer password
Route::resource('/customers/customer-manual-update-password', App\Http\Controllers\Menu\Customer\UpdatePasswordController::class)->only('update');
// Customer Lead Contacts
Route::resource('/customers/lead-contacts', App\Http\Controllers\Menu\Customer\LeadContactController::class)->only('store', 'show', 'destroy');
// Customer Leads
Route::resource('/customers/leads', App\Http\Controllers\Menu\Customer\LeadController::class)->except('edit');
// Customer Search Functionality
Route::post('/customers/results', [App\Http\Controllers\Menu\Customer\SearchController::class, 'show'])->name('customers.results');
// Customers Datatables Route.
Route::get('/customers-dt', [App\Http\Controllers\Menu\Customer\DatatableController::class, 'create'])->name('customers-dt.create');
// Customers
Route::resource('customers', App\Http\Controllers\Menu\Customer\CustomerController::class)->except('edit');

/*
|--------------------------------------------------------------------------
| Manage Contractor Routes
|--------------------------------------------------------------------------
*/

// Contractor Qualifications
Route::resource('/contractors/contractor-qualifications', App\Http\Controllers\Menu\Contractor\QualificationController::class);
// Contractor Testimonials
Route::resource('/contractors/contractor-testimonials', App\Http\Controllers\Menu\Contractor\TestimonialController::class);
// Contractor Members
Route::resource('/contractors', App\Http\Controllers\Menu\Contractor\ContractorController::class)->except('edit');

/*
|--------------------------------------------------------------------------
| Manage Staff Member Routes
|--------------------------------------------------------------------------
*/

// Manage Staff
Route::resource('/staff/staff-qualifications', App\Http\Controllers\Menu\Staff\QualificationController::class);
// Manage Staff
Route::resource('/staff', App\Http\Controllers\Menu\Staff\StaffController::class)->except('edit');

/*
|--------------------------------------------------------------------------
| Manage Tradesperson Routes
|--------------------------------------------------------------------------
*/

// Tradesperson Qualifications
Route::resource('/tradespersons/tradesperson-qualifications', App\Http\Controllers\Menu\Tradesperson\QualificationController::class);
// Tradesperson Rates
Route::resource('/tradespersons/tradesperson-rates', App\Http\Controllers\Menu\Tradesperson\RateController::class);
// Tradesperson Testimonials
Route::resource('/tradespersons/tradesperson-testimonials', App\Http\Controllers\Menu\Tradesperson\TestimonialController::class);
// Tradespersons
Route::resource('/tradespersons', App\Http\Controllers\Menu\Tradesperson\TradespersonController::class)->except('edit');

/*
|--------------------------------------------------------------------------
| Incoming Call Routes
|--------------------------------------------------------------------------
*/

Route::resource('incoming-call', App\Http\Controllers\Menu\IncomingCall\IncomingCallController::class)->only('index', 'store');

/*
|--------------------------------------------------------------------------
| Manage Job Routes
|--------------------------------------------------------------------------
*/

// FILTERED JOB TYPE DATATABLES
// Pending Datatables
Route::get('/jobs/jobs-pending-dt', [App\Http\Controllers\Menu\Job\Filtered\PendingDatableController::class, 'create'])->name('jobs-pending-dt.create');
// Sold Datatables
Route::get('/jobs/jobs-sold-dt', [App\Http\Controllers\Menu\Job\Filtered\SoldDatableController::class, 'create'])->name('jobs-sold-dt.create');
// Filter Action
Route::post('/jobs/jobs-filter', [App\Http\Controllers\Menu\Job\Filtered\FilterController::class, 'index'])->name('jobs-filter.index');
// Default Datatables
Route::get('/jobs/jobs-default-dt', [App\Http\Controllers\Menu\Job\Filtered\DefaultDatableController::class, 'create'])->name('jobs-default-dt.create');
// Completed Datatables
Route::get('/jobs/jobs-completed-dt', [App\Http\Controllers\Menu\Job\Filtered\CompletedDatableController::class, 'create'])->name('jobs-completed-dt.create');

// JOB IMAGES
// Manage Image Permissions
Route::post('/job-images/job-images-permissions', [App\Http\Controllers\Menu\Job\ImagePermissionController::class, 'update'])->name('job-images-permissions.update');
// Manage PDF images
Route::resource('/job-images/manage-pdf-images', App\Http\Controllers\Menu\Job\ManagePdfImageController::class)->only('show', 'update');
// Upload Job images
Route::resource('/job-images', App\Http\Controllers\Menu\Job\ImageController::class)->except('index', 'edit');

// QUOTE IMAGES
// Manage Image That Appear On A Specific Quote
Route::resource('/job-images/quote-images', App\Http\Controllers\Menu\Job\QuoteImageController::class)->only('create', 'update');

// JOB ACTIONS
// Set Approx Start Date Email To Customer
Route::resource('/jobs/send-data-entered-email', App\Http\Controllers\Menu\Job\SetApproxStartDateController::class)->only('store');
// Update Job Quote Sent Status
Route::resource('/jobs/update-quote-sent-status', App\Http\Controllers\Menu\Job\UpdateQuoteSentStatusController::class)->only('update');
// Update Job Progress Status
Route::resource('/jobs/update-job-progress', App\Http\Controllers\Menu\Job\UpdateJobProgressStatusController::class)->only('update');
// Update Job Status
Route::resource('/jobs/update-job-status', App\Http\Controllers\Menu\Job\UpdateJobStatusController::class)->only('update');
// Update Job Follow Up Call Status
Route::resource('/jobs/update-follow-up-call-status', App\Http\Controllers\Menu\Job\UpdateFollowUpCallStatusController::class)->only('update');
// Send Job Update Email.
Route::post('/jobs/send-selected-sms', [App\Http\Controllers\Menu\Job\SendSmsController::class, 'store'])->name('send-selected-sms.store');

// JOB NOTES
// Jobs Note Reply Route
Route::resource('/jobs/job-internal-note-response', App\Http\Controllers\Menu\Job\InternalNoteReplyController::class)->only('store');
// Job Internal Notes
Route::resource('/jobs/job-internal-notes', App\Http\Controllers\Menu\Job\InternalNoteController::class);
// Jobs Note Reply Route
Route::resource('/jobs/job-note-response', App\Http\Controllers\Menu\Job\NoteReplyController::class)->only('store');
// Job Public Notes
Route::resource('/jobs/job-notes', App\Http\Controllers\Menu\Job\NoteController::class);

// JOB FLAGS
// Job Flags from Job page
Route::resource('job-flags', App\Http\Controllers\Menu\Job\FlagController::class);

// JOB QUOTE ACTIONS ************************************* These should prob be in quote!!!!!!!
// View Contractors Job Report - 'meas' button
Route::resource('jobs/contractor-job-report', App\Http\Controllers\Menu\Job\ContractorJobReportController::class)->only('show');
// View Customer View Quote - 'quote' button
Route::resource('jobs/job-view-customer-quote', App\Http\Controllers\Menu\Job\CustomerViewQuoteController::class)->only('create', 'show');
// View Customer View Quote - 'quote' button
Route::resource('jobs/job-view-work-order', App\Http\Controllers\Menu\Job\ViewWorkOrderController::class)->only('show');
// Send the quote by email to the customer
Route::post('/jobs/job-email-quote-to-customer', [App\Http\Controllers\Menu\Job\EmailQuoteToCustomerController::class, 'create'])->name('job-email-quote-to-customer.create');

// JOBS
// Jobs Index Datatable
Route::get('/jobs/jobs-dt', [App\Http\Controllers\Menu\Job\JobDatatableController::class, 'create'])->name('jobs-dt.create');
// JOBS
Route::resource('jobs', App\Http\Controllers\Menu\Job\JobController::class);

/*
|--------------------------------------------------------------------------
| Manage Quotes Routes
|--------------------------------------------------------------------------
*/

// QUOTE REQUESTS
Route::resource('quote-requests', App\Http\Controllers\Menu\Quote\QuoteRequestController::class);
Route::resource('convert-quote-requests', App\Http\Controllers\Menu\Quote\ConvertQuoteRequestController::class);
Route::resource('quick-quote', App\Http\Controllers\Menu\Quote\QuickQuoteController::class);

// QUOTE
// Filter Action
Route::post('/quotes/quotes-filter', [App\Http\Controllers\Menu\Quote\Filtered\FilterController::class, 'index'])->name('quotes-filter.index');
// Default Datatables
Route::get('/quotes/quotes-default-dt', [App\Http\Controllers\Menu\Quote\Filtered\DefaultDatableController::class, 'create'])->name('quotes-default-dt.create');
// Quotes Datatable
Route::get('/quotes-dt', [App\Http\Controllers\Menu\Quote\QuoteDatatableController::class, 'create'])->name('quotes-dt.create');
// Add payments and subtract price from the quote 
Route::get('/quote-finalise', [App\Http\Controllers\Menu\Quote\FinaliseQuoteController::class, 'index'])->name('quote.finalise');

Route::post('/send-customer-credentials-email', [App\Http\Controllers\Menu\Quote\SendOnlineQuoteAccessEmailController::class, 'store'])->name('send-customer-credentials-email.store');

// QUOTE
// Quotes menu
Route::resource('quotes', App\Http\Controllers\Menu\Quote\QuoteController::class);
// Add payments and subtract price from the quote 
Route::resource('quotes-finalise', App\Http\Controllers\Menu\Quote\FinaliseQuoteController::class);

// QUOTE PRODUCTS
Route::resource('quote-products', App\Http\Controllers\Menu\Quote\ProductController::class);

// QUOTE RATES
Route::resource('quote-rates', App\Http\Controllers\Menu\Quote\RateController::class);

// QUOTE TASKS
Route::resource('quote-tasks', App\Http\Controllers\Menu\Quote\TaskController::class);

// QUOTE PAYMENTS
// Quote Payments.
Route::resource('quote-payments', App\Http\Controllers\Menu\Quote\PaymentController::class);
// Quote Scheduled Payments in tax invoice section.
Route::resource('quote-scheduled-payments', App\Http\Controllers\Menu\Quote\ScheduledPaymentController::class);

// QUOTE DEPOSIT
// Customer view of the quote deposit document. This is the sum document of all deposit payment types for the customer. 
Route::resource('/quote-deposits', App\Http\Controllers\Menu\Quote\DepositController::class);

// Update Job Status
Route::resource('/update-quote-status', App\Http\Controllers\Menu\Quote\UpdateQuoteStatusController::class)->only('update');

// Update Job Status
Route::resource('/update-quote-expected-payment', App\Http\Controllers\Menu\Quote\UpdateExpectedPaymentStatusController::class)->only('update');

// QUOTE TAX INVOICE
// Quote tax invoice extra info.
Route::resource('/quote-tax-invoice-extra-info', App\Http\Controllers\Menu\Quote\TaxInvoiceExtraInfoController::class);
// Quote tax invoice items Resource
Route::resource('/quote-tax-invoice-items', App\Http\Controllers\Menu\Quote\TaxInvoiceItemController::class);
// Manually set the date of the tax invoice. (YES THIS REDICULOUS BUT IT IS AS REQUESTED).
Route::resource('/quote-tax-invoice-update-date', App\Http\Controllers\Menu\Quote\UpdateTaxInvoiceDateController::class);
// View customer version of tax invoice.
Route::resource('/quote-tax-invoices', App\Http\Controllers\Menu\Quote\TaxInvoiceController::class);
// View customer version of tax invoice.
Route::resource('/quote-mark-as-accepted-custmer', App\Http\Controllers\Menu\Quote\CustomerMarkAsAcceptedController::class);

// QUOTE FINAL RECEIPT
// View customer version of final receipt.
Route::resource('/quote-final-receipts', App\Http\Controllers\Menu\Quote\FinalReceiptController::class);

// Allow tradesperson to accept a card payment when the job is completed.
Route::resource('/allow-accept-card-payment', App\Http\Controllers\Menu\Quote\AllowAcceptCardPaymentController::class)->only('update');

// Allow tradesperson to accept a card payment when the job is completed.
Route::resource('/allow-pre-receipt', App\Http\Controllers\Menu\Quote\AllowPreReceiptController::class)->only('update');

/*
|--------------------------------------------------------------------------
| Manage Invoice Routes
|--------------------------------------------------------------------------
*/

// Download as PDF.
Route::resource('/invoices-download-pdf', App\Http\Controllers\Menu\Invoice\DownloadPdfController::class)->only('create');
// Mark Invoice As Paid.
Route::resource('/invoices-mark-as-paid', App\Http\Controllers\Menu\Invoice\MarkAsPaidController::class)->only('update');
// Paid invoices from staff.
Route::resource('/invoices-paid', App\Http\Controllers\Menu\Invoice\PaidInvoiceController::class)->only('index', 'show');
// Unpaid Invoices from staff.
Route::resource('/invoices-staff-confirmation', App\Http\Controllers\Menu\Invoice\StaffConfirmationController::class);
// Unpaid Invoices from staff displayed in a group.
Route::resource('/invoices-group', App\Http\Controllers\Menu\Invoice\InvoiceGroupController::class);
// Group invoices resource routes, once they have been paid.
Route::resource('/invoices/group-invoices', App\Http\Controllers\Menu\Invoice\GroupInvoiceController::class);
// Group invoices datatable.
Route::get('/invoices/group-invoices-dt', [App\Http\Controllers\Menu\Invoice\GroupInvoiceDatatableController::class, 'create'])->name('group-invoices-dt.create');
// Group invoices resource routes, once they have been paid.
Route::resource('/invoices/invoice-commissions', App\Http\Controllers\Menu\Invoice\CommissionController::class);
// Group invoices resource routes, once they have been paid.
Route::get('/invoices/invoice-commissions-dt', [App\Http\Controllers\Menu\Invoice\CommissionDatatableController::class, 'create'])->name('invoice-commissions-dt.create');
// Group invoices resource routes, once they have been paid.
Route::get('/invoices/invoice-commissions-completed-dt', [App\Http\Controllers\Menu\Invoice\CompletedCommissionDatatableController::class, 'create'])->name('invoice-commissions-completed-dt.create');
// Convert the commission item to an invoice.
Route::resource('/invoices/invoice-commissions-convert', App\Http\Controllers\Menu\Invoice\ConvertCommissionToInvoiceController::class)->only('update');
// The invoice main menu card.
Route::view('/invoices', 'menu.invoices.index')->name('invoices.index');
// Unpaid Invoices from staff.
Route::resource('/invoices-outstanding', App\Http\Controllers\Menu\Invoice\InvoiceController::class);

/*
|--------------------------------------------------------------------------
| Systems Routes
|--------------------------------------------------------------------------
*/

// System Management Controller Resource Route
Route::resource('/systems', App\Http\Controllers\Menu\System\SystemController::class)->only('show', 'edit', 'update');

/*
|--------------------------------------------------------------------------
| Search Routes
|--------------------------------------------------------------------------
*/

// Follow Up Call Search Results Datatable
Route::get('/search/search-follow-up-process-r-dt', [App\Http\Controllers\Menu\Search\FollowUpCallResultsDatableController::class, 'create'])->name('search-follow-up-process-r-dt.create');
// Follow Up Call Search Index Datatable
Route::get('/search/search-follow-up-process-dt', [App\Http\Controllers\Menu\Search\FollowUpCallController::class, 'create'])->name('search-follow-up-process-dt.create');
// Follow Up Call Search Results Page
Route::post('/search/search-follow-up-process-results', [App\Http\Controllers\Menu\Search\FollowUpCallController::class, 'show'])->name('search-follow-up-process-results.show');
// Follow Up Call Search Index Page
Route::resource('search/search-follow-up-process', App\Http\Controllers\Menu\Search\FollowUpCallController::class)->only('index');
// Property Search Results Page
Route::post('/search/search-properties-results', [App\Http\Controllers\Menu\Search\PropertySearchController::class, 'show'])->name('search-properties-results.show');
// Property Search Index Page
Route::resource('search/search-properties', App\Http\Controllers\Menu\Search\PropertySearchController::class)->only('index');
// User Search Results Page
Route::post('/search/search-users-results', [App\Http\Controllers\Menu\Search\UserSearchController::class, 'show'])->name('search-user-results.show');
// User Search Index Page
Route::resource('search/search-users', App\Http\Controllers\Menu\Search\UserSearchController::class)->only('index');
// Global Search Menu Route
Route::resource('/search', App\Http\Controllers\Menu\Search\SearchController::class)->only('index');

/*
|--------------------------------------------------------------------------
| Notes Menu Routes
|--------------------------------------------------------------------------
*/

// Pending Filtered notes Datatable
Route::get('/notes/notes-filter-new-dt', [App\Http\Controllers\Menu\Note\Filtered\FilteredNewDatatableController::class, 'create'])->name('notes-filter-new-dt.create');
// Pending Filtered notes Datatable
Route::get('/notes/notes-filter-pending-dt', [App\Http\Controllers\Menu\Note\Filtered\FilteredPendingDatatableController::class, 'create'])->name('notes-filter-pending-dt.create');
// Filter Action
Route::post('/notes/notes-filter', [App\Http\Controllers\Menu\Note\Filtered\FilterController::class, 'index'])->name('notes-filter.index');
// Show the selected note to other users.
Route::resource('/notes/notes-show-to-users', App\Http\Controllers\Menu\Note\ShowToUsersController::class)->only('update');
// Convert Internal Job Note To Public Note
Route::resource('/notes/notes-show-to-customer', App\Http\Controllers\Menu\Note\ShowToCustomerController::class)->only('update');
// Notes Menu Route - Main Menu Button
Route::resource('/notes', App\Http\Controllers\Menu\Note\NoteController::class)->only('index', 'show', 'update', 'destroy');
// Notes Load New Notes Datatable Route
Route::get('/notes-dt-new', [App\Http\Controllers\Menu\Note\NewNoteDatatableController::class, 'create'])->name('notes-dt-new.create');
// Notes Load New Notes Action Buttons Datatable Route
Route::view('/notes-dt-new-actions', '')->name('notes-dt-new.actions');
// Notes Load Pending Notes Datatable Route
Route::get('/notes-dt-pending', [App\Http\Controllers\Menu\Note\PendingNoteDatatableController::class, 'create'])->name('notes-dt-pending.create');
// Notes Load Pending Notes Action Buttons Datatable Route
Route::view('/notes-dt-pending-actions', '')->name('notes-dt-pending.actions');
// Notes Load Acknowledged Notes Datatable Route
Route::get('/notes-dt-acknowledged', [App\Http\Controllers\Menu\Note\AcknowledgedNoteDatatableController::class, 'create'])->name('notes-dt-acknowledged.create');
// Notes Load Acknowledged Notes Action Buttons Datatable Route
Route::view('/notes-dt-acknowledged-actions', '')->name('notes-dt-acknowledged.actions');
// Note Menu Job Note Response
Route::resource('/note-responses', App\Http\Controllers\Menu\Note\NoteResponseController::class)->only('store', 'destroy');
// Note Menu Route - Main Menu Button
Route::resource('/notes-trashed', App\Http\Controllers\Menu\Note\TrashedController::class)->only('index', 'show', 'update', 'destroy');
// Note Menu Delete All Trashed Quote Notes
Route::resource('/notes-empty-trash', App\Http\Controllers\Menu\Note\EmptyTrashController::class)->only('index');
// Note Menu Manually Toggle Allow Trades To See.
Route::resource('/notes-allow-trades-to-view', App\Http\Controllers\Menu\Note\AllowTradesToViewController::class)->only('update');
// Note Menu Manually Mark Note As Read By The Recipient.
Route::resource('/notes-mark-as-recipient-read', App\Http\Controllers\Menu\Note\MarkRecipientAsReadController::class)->only('update');

/*
|--------------------------------------------------------------------------
| Manage Calendar Routes
|--------------------------------------------------------------------------
*/

// Calendar resource routes
Route::resource('calendar', App\Http\Controllers\Menu\Calendar\CalendarController::class);
// Calendar resource routes
Route::get('calendar-dt', [App\Http\Controllers\Menu\Calendar\CalendarDatatableController::class, 'create'])->name('calendar-dt.create');
// Store the calendar note.
Route::resource('/event-notes', App\Http\Controllers\Menu\Calendar\NoteController::class)->only('store');
// Search for event results..
Route::resource('/event-search', App\Http\Controllers\Menu\Calendar\SearchController::class)->only('index');
// Load the events in the calendar 
Route::resource('events', App\Http\Controllers\Menu\Calendar\EventController::class)->only('create');

/*
|--------------------------------------------------------------------------
| Reports Routes
|--------------------------------------------------------------------------
*/

// Index route
Route::get('/reports', [App\Http\Controllers\Menu\Report\ReportController::class, 'index'])->name('reports.index');

// CUSTOMER ACCOUNT CLASSES
// Customer account classes report
Route::get('/reports/account-classes-report', [App\Http\Controllers\Menu\Report\AccountClassController::class, 'index'])->name('account-classes-report.index');
// Customer account classes report results
Route::post('/reports/account-classes-show', [App\Http\Controllers\Menu\Report\AccountClassController::class, 'show'])->name('account-class-report.show');

// CUSTOMER REFERAL
// Customer referral report
Route::get('/reports/customer-referral-report', [App\Http\Controllers\Menu\Report\CustomerReferralController::class, 'index'])->name('customer-referral-report.index');
// Customer referral report results
Route::post('/reports/customer-referral-show', [App\Http\Controllers\Menu\Report\CustomerReferralController::class, 'show'])->name('customer-referral-report.show');

// JOB STATISTICS
// Job statistics report
Route::get('/reports/job-statistics-report', [App\Http\Controllers\Menu\Report\JobStatisticsController::class, 'index'])->name('job-statistics-report.index');
// Job statistics report results
Route::post('/reports/job-statistics-show', [App\Http\Controllers\Menu\Report\JobStatisticsController::class, 'show'])->name('job-statistics-report.show');

// PAYMENTS RECEIVED STATISTICS (Cash Payments)
// Cash payments statistics report
Route::get('/reports/cash-payments-statistics-report', [App\Http\Controllers\Menu\Report\CashPaymentsStatisticsController::class, 'index'])->name('cash-payments-report.index');
// Cash payments statistics report results
Route::post('/reports/cash-payments-statistics-show', [App\Http\Controllers\Menu\Report\CashPaymentsStatisticsController::class, 'show'])->name('cash-payments-report.show');

// QUOTE STATISTICS
// Quote statistics report
Route::get('/reports/quote-statistics-report', [App\Http\Controllers\Menu\Report\QuoteStatisticsController::class, 'index'])->name('quote-statistics-report.index');
// Quote statistics report results
Route::post('/reports/quote-statistics-show', [App\Http\Controllers\Menu\Report\QuoteStatisticsController::class, 'show'])->name('quote-statistics-report.show');

// STAFF SALES
// Staff sales statistics report
Route::get('/reports/staff-sales-statistics-report', [App\Http\Controllers\Menu\Report\StaffSalesController::class, 'index'])->name('staff-sales-statistics-report.index');
// Staff sales statistics report results
Route::post('/reports/staff-sales-statistics-show', [App\Http\Controllers\Menu\Report\StaffSalesController::class, 'show'])->name('staff-sales-statistics-report.show');

// SUBURB REPORT
// Suburb report index
Route::get('/reports/suburb-report', [App\Http\Controllers\Menu\Report\SuburbController::class, 'index'])->name('suburb-report.index');

// INDIVIDUAL SERVEY
// Individual survey report
Route::get('/reports/survey-individual-report', [App\Http\Controllers\Menu\Report\SurveyIndividualController::class, 'index'])->name('survey-individual-report.index');
// Individual survey report results
Route::post('/reports/survey-individual-report-show', [App\Http\Controllers\Menu\Report\SurveyIndividualController::class, 'show'])->name('survey-individual-report.show');

// OVERALL SERVEY
// Overall survey report
Route::get('/reports/survey-overall-report', [App\Http\Controllers\Menu\Report\SurveyOverallController::class, 'index'])->name('survey-overall-report.index');
// Overall survey report results
Route::post('/reports/survey-overall-report-show', [App\Http\Controllers\Menu\Report\SurveyOverallController::class, 'show'])->name('survey-overall-report.show');

// WRITTEN OFF PAYMENTS
// Written off payments index view
Route::get('/reports/written-off-report', [App\Http\Controllers\Menu\Report\WrittenOffController::class, 'index'])->name('written-off-report.index');
// Written off payments show view
Route::post('/reports/written-off-report-show', [App\Http\Controllers\Menu\Report\WrittenOffController::class, 'show'])->name('written-off-report.show');

/*
|--------------------------------------------------------------------------
| Stock Control Routes
|--------------------------------------------------------------------------
*/

// PENDING ORDERS
// Pending Orders Index Menu Route
Route::resource('/manage/stock-control/pending-orders', App\Http\Controllers\Menu\StockControl\Order\PendingController::class);
// Pending Orders Confirm Order
Route::resource('/manage/stock-control/pending-orders-confirm-order', App\Http\Controllers\Menu\StockControl\Order\ConfirmOrderController::class)->only('update');
// Pending Orders Confirm Postage
Route::resource('/manage/stock-control/pending-orders-confirm-postage', App\Http\Controllers\Menu\StockControl\Order\ConfirmPostageController::class)->only('update');
// PREVIOUS ORDERS
// Previous Orders Index Menu Route
Route::resource('/manage/stock-control/previous-orders', App\Http\Controllers\Menu\StockControl\Order\PreviousController::class);
// INVENTORY
// Inventory Index Menu Route
Route::resource('/manage/stock-control/inventory', App\Http\Controllers\Menu\StockControl\Inventory\InventoryController::class)->only('index');
// MENU
// Stock Control Index Menu Route
Route::resource('/manage/stock-control', App\Http\Controllers\Menu\StockControl\StockControlController::class)->only('index');

/*
|--------------------------------------------------------------------------
| Equipment Routes
|--------------------------------------------------------------------------
*/

// Equipment Documents Resource Route
Route::resource('/equipment/equipment-documents', App\Http\Controllers\Menu\Equipment\DocumentController::class);
// Equipment Documents Download Route
Route::resource('/equipment/equipment-documents-download', App\Http\Controllers\Menu\Equipment\DocumentDownloadController::class)->only('show');
// Equipment Inspections Resource Route
Route::resource('/equipment/equipment-inspections', App\Http\Controllers\Menu\Equipment\InspectionController::class)->except('index');
Route::resource('/equipment/equipment-inspection-images', App\Http\Controllers\Menu\Equipment\InspectionImageController::class)->except('index');
Route::resource('/equipment/equipment-inspection-dropzone', App\Http\Controllers\Menu\Equipment\InspectionDropzoneController::class)->only('store');
// Equipment Notes Resource Route
Route::resource('/equipment/equipment-notes', App\Http\Controllers\Menu\Equipment\NoteController::class)->except('index');
// Equipment Menu Resource Route
Route::resource('/equipment', App\Http\Controllers\Menu\Equipment\EquipmentController::class);

/*
|--------------------------------------------------------------------------
| Email Routes
|--------------------------------------------------------------------------
*/

// Generic Email
Route::get('/emails/generic-emails-dt', [App\Http\Controllers\Menu\Email\Generic\DatatableController::class, 'create'])->name('generic-emails-dt.create');
Route::resource('/emails/generic-emails-download-file', App\Http\Controllers\Menu\Email\Generic\DownloadAttachmentController::class)->only('show');
Route::resource('/emails/generic-emails-empty-trash', App\Http\Controllers\Menu\Email\Generic\EmptyTrashController::class)->only('index');
Route::get('/emails/generic-emails-trash-dt', [App\Http\Controllers\Menu\Email\Generic\TrashDatatableController::class, 'create'])->name('generic-emails-trash-dt.create');
Route::resource('/emails/generic-emails-trash', App\Http\Controllers\Menu\Email\Generic\TrashController::class)->only('index', 'show', 'update', 'destroy');
Route::resource('/emails/generic-emails', App\Http\Controllers\Menu\Email\Generic\EmailController::class)->except('edit');

// Email Template
Route::resource('/emails/email-templates', App\Http\Controllers\Menu\Email\Template\EmailTemplateController::class);

// Group Email
Route::resource('/emails/group-emails-download-file', App\Http\Controllers\Menu\Email\Group\DownloadAttachmentController::class)->only('show');
Route::resource('/emails/group-emails-empty-trash', App\Http\Controllers\Menu\Email\Group\EmptyTrashController::class)->only('index');
Route::resource('/emails/group-emails-trash', App\Http\Controllers\Menu\Email\Group\TrashController::class)->only('index', 'show', 'update', 'destroy');
Route::resource('/emails/group-emails', App\Http\Controllers\Menu\Email\Group\GroupEmailController::class);

// Group Email User Groups
Route::resource('/emails/email-recipient-groups', App\Http\Controllers\Menu\Email\UserGroup\UserGroupController::class)->except('edit');

// MANUALLY SEND QUOTE REMINDER EMAILS BUTTON, THIS IS ONLY TEMPARARY. **********
Route::get('/emails/send-quote-reminder-emails', [App\Http\Controllers\Menu\Email\QuoteReminder\SendQuoteReminderController::class, 'index'])->name('send-quote-reminder-emails.index');

// Quote Reminder Email Index Route
Route::resource('/emails/quote-reminder-emails', App\Http\Controllers\Menu\Email\QuoteReminder\QuoteReminderController::class)->only('index', 'update');
// Quote Reminder Reset Button Delete Response Object
Route::resource('/emails/quote-reminder-emails-response', App\Http\Controllers\Menu\Email\QuoteReminder\ResetResponseController::class)->only('update');
// Quote Reminder Reset Button Delete Response Object
Route::resource('/emails/quote-reminder-emails-contact', App\Http\Controllers\Menu\Email\QuoteReminder\ContactController::class)->only('update');



// Default Email Response Text
Route::resource('/emails/default-email-response-text', App\Http\Controllers\Menu\Email\QuoteReminder\DefaultEmailResponseTextController::class);
// Default Email Response Text
Route::resource('/emails/set-quote-email-reminders', App\Http\Controllers\Menu\Email\QuoteReminder\SentController::class);
// Acknowledge Reminder Email Response 
Route::resource('/emails/ack-email-reminder-response', App\Http\Controllers\Menu\Email\QuoteReminder\AcknowledgeController::class);

// Render Example Of Email In The View
Route::resource('/emails/email-template-render-example', App\Http\Controllers\Menu\Email\Template\ViewEmailTemplateController::class);

// Email Menu
Route::resource('/emails', App\Http\Controllers\Menu\Email\EmailController::class)->only('index');

/*
|--------------------------------------------------------------------------
| SMS Routes
|--------------------------------------------------------------------------
*/

// Generic SMS Resource datatable Route
Route::get('/sms/generic-sms-dt', [App\Http\Controllers\Menu\Sms\GenericSmsDatatableController::class, 'create'])->name('generic-sms-dt.create');
// Generic SMS Resource Routes
Route::resource('/sms/generic-sms', App\Http\Controllers\Menu\Sms\GenericSmsController::class);

// Group SMS Resource datatable Route
Route::get('/sms/group-sms-dt', [App\Http\Controllers\Menu\Sms\GroupSmsDatatableController::class, 'create'])->name('group-sms-dt.create');
// Group SMS Resource Routes
Route::resource('/sms/group-sms', App\Http\Controllers\Menu\Sms\GroupSmsController::class);

// SMS Templates Resource datatable Route
Route::get('/sms/sms-templates-dt', [App\Http\Controllers\Menu\Sms\SmsTemplateDatatableController::class, 'create'])->name('sms-templates-dt.create');
// SMS Templates Resource Routes
Route::resource('/sms/sms-templates', App\Http\Controllers\Menu\Sms\SmsTemplateController::class);

// SMS Recipient Group Resource Routes
Route::resource('/sms/sms-recipient-groups', App\Http\Controllers\Menu\Sms\SmsRecipientGroupController::class);

// SMS Unsubscribe Route
Route::get('/sms-unsubscribe', [App\Http\Controllers\Menu\Sms\UnsubscribeController::class, 'index'])->name('sms-unsubscribe.index');

// SMS Menu Route
Route::get('/sms', [App\Http\Controllers\Menu\Sms\SmsController::class, 'index'])->name('sms.index');

/*
|--------------------------------------------------------------------------
| Manage Messages Routes
|--------------------------------------------------------------------------
*/

// Download message attachment.
Route::resource('/messages-download-attachment', App\Http\Controllers\Menu\Message\DownloadAttachmentController::class)->only('show');
// Delete all trashed messages.
Route::resource('/messages-empty-trash', App\Http\Controllers\Menu\Message\EmptyTrashController::class)->only('index');
// All read messages.
Route::resource('/messages-archive', App\Http\Controllers\Menu\Message\ArchiveController::class)->only('index', 'show', 'destroy');
// Message trash.
Route::resource('/messages-trash', App\Http\Controllers\Menu\Message\TrashController::class)->only('index', 'show', 'update', 'destroy');
// All new messages.
Route::resource('/messages-reply', App\Http\Controllers\Menu\Message\ReplyController::class)->only('store');
// All new messages.
Route::resource('/messages', App\Http\Controllers\Menu\Message\MessageController::class)->only('index', 'create', 'store', 'show',  'update', 'destroy');

/*
|--------------------------------------------------------------------------
| Site Contact Routes
|--------------------------------------------------------------------------
*/

// Manage Site Contact Form
Route::resource('/site-contacts', App\Http\Controllers\Menu\SiteContact\SiteContactController::class)->only('index', 'show', 'update', 'destroy');
Route::resource('/site-contacts-response', App\Http\Controllers\Menu\SiteContact\SiteContactResponseController::class)->only('store');
// Site Contact Menu Trashed Site Contacts 
Route::resource('/site-contact/site-contacts-trashed', App\Http\Controllers\Menu\SiteContact\TrashedController::class)->only('index', 'show', 'update', 'destroy');
// Site Contact Menu Delete All Trashed Site Contacts
Route::resource('/site-contact/site-contacts-trashed-delete-all', App\Http\Controllers\Menu\SiteContact\EmptyTrashController::class)->only('index');
// Add Site Contact To Spam Filter List 
Route::resource('/site-contacts/site-contacts-spam-filter', App\Http\Controllers\Menu\SiteContact\SpamController::class)->only('store');

/*
|--------------------------------------------------------------------------
| Content Routes
|--------------------------------------------------------------------------
*/

// Article Categories Resource Routes
Route::resource('/content/content-categories', App\Http\Controllers\Menu\Content\CategoryController::class);
// Article Tags Resource Routes
Route::resource('/content/content-tags', App\Http\Controllers\Menu\Content\TagController::class);
// Blog Resource Routes
Route::post('/content/blogs-images-dropzone', [App\Http\Controllers\Menu\Content\BlogDropzoneController::class, 'store'])->name('blogs-images-dropzone.store');
Route::resource('/content/blogs-images', App\Http\Controllers\Menu\Content\BlogImageController::class);
Route::resource('/content/blogs', App\Http\Controllers\Menu\Content\BlogController::class);
// News Article Resource Routes
Route::resource('/content/article-image-dropzone', App\Http\Controllers\Menu\Content\ArticleDropzoneController::class)->only('store');
Route::resource('/content/article-images', App\Http\Controllers\Menu\Content\ArticleImageController::class);
Route::resource('/content/articles', App\Http\Controllers\Menu\Content\ArticleController::class);
// Content Menu Index Route
Route::resource('/content', App\Http\Controllers\Menu\Content\ContentController::class)->only('index');

/*
|--------------------------------------------------------------------------
| Settings Routes
|--------------------------------------------------------------------------
*/

// Account Classes Datatables Route
Route::get('/settings/account-classes-dt', [App\Http\Controllers\Menu\Settings\AccountClass\AccountClassDatatableController::class, 'create'])->name('account-classes-dt.create');
// Account Classes Resource Routes
Route::resource('/settings/account-classes', App\Http\Controllers\Menu\Settings\AccountClass\AccountClassController::class);
// Account Roles Resource Routes
Route::resource('/settings/account-roles', App\Http\Controllers\Menu\Settings\AccountRoleController::class)->only('index', 'show');
// Building Styles Settings
Route::resource('/settings/building-style-settings', App\Http\Controllers\Menu\Settings\BuildingStyleController::class)->except('show');
// Building Styles Posts Settings
Route::resource('/settings/building-style-post-t-settings', App\Http\Controllers\Menu\Settings\BuildingStylePostTypeController::class);
// Building Styles Posts Settings
Route::resource('/settings/building-style-post-settings', App\Http\Controllers\Menu\Settings\BuildingStylePostController::class);
// Building Styles Settings
Route::resource('/settings/building-type-settings', App\Http\Controllers\Menu\Settings\BuildingTypeController::class)->except('show');
// Building Styles Settings
Route::resource('/settings/colour-settings', App\Http\Controllers\Menu\Settings\ColourController::class)->only('index');
// Default Image Text Resource Routes
Route::resource('/settings/default-additional-text-settings', App\Http\Controllers\Menu\Settings\DefaultAditionalCommentTextController::class);
// Default Image Text Resource Routes
Route::resource('/settings/default-image-text-settings', App\Http\Controllers\Menu\Settings\DefaultImageTextController::class);
// Default Image Title Resource Routes
Route::resource('/settings/default-image-title-settings', App\Http\Controllers\Menu\Settings\DefaultImageTitleController::class);
// Discount Code Settings Resource Routes
Route::resource('/settings/default-properties-settings', App\Http\Controllers\Menu\Settings\DefaultPropertiesToViewController::class);
// Discount Code Settings Resource Routes
Route::resource('/settings/dimensions-settings', App\Http\Controllers\Menu\Settings\DimensionController::class)->only('index');
// Discount Code Settings Resource Routes
Route::resource('/settings/discount-code-settings', App\Http\Controllers\Menu\Settings\DiscountCodeController::class)->except('show');
// Discount Code Settings Resource Routes
Route::resource('/settings/double-storey-surcharge-settings', App\Http\Controllers\Menu\Settings\DoubleStoreySurchargeController::class)->only('update');
// Equipment Categories Settings Resource Routes
Route::resource('/settings/equipment-category-settings', App\Http\Controllers\Menu\Settings\EquipmentCategoryController::class);
// Equipment Groups Settings Resource Routes
Route::resource('/settings/equipment-group-settings', App\Http\Controllers\Menu\Settings\EquipmentGroupController::class);
// Frequently Asked Questions Settings Routes
Route::resource('/settings/faq-settings', App\Http\Controllers\Menu\Settings\FaqController::class);
// Follow Up Call Statuses Settings Routes
Route::resource('/settings/follow-up-call-settings', App\Http\Controllers\Menu\Settings\FollowUpCallController::class)->except('delete');
// Inspection Types Settings Resource Routes
Route::resource('/settings/inspection-type-settings', App\Http\Controllers\Menu\Settings\InspectionTypeController::class);
// Job Statuses Settings Resource Routes
Route::resource('/settings/job-progress-settings', App\Http\Controllers\Menu\Settings\JobProgressController::class)->except('show');
// Job Statuses Settings Resource Routes
Route::resource('/settings/job-status-settings', App\Http\Controllers\Menu\Settings\JobStatusController::class)->except('show');
// Job Types Settings Resource Routes
Route::resource('/settings/job-type-settings', App\Http\Controllers\Menu\Settings\JobTypeController::class);
// Login Status Settings Resource Routes
Route::resource('/settings/login-statuses-settings', App\Http\Controllers\Menu\Settings\LoginStatusController::class);
// Manually Added Testimonials Settings Resource Routes
Route::resource('/settings/manual-testimonials-settings', App\Http\Controllers\Menu\Settings\ManualTestimonialController::class);
// Material Types Settings Resource Routes
Route::resource('/settings/material-type-settings', App\Http\Controllers\Menu\Settings\MaterialTypeController::class)->except('show');
// Payment Methods Settings Index Route
Route::resource('/settings/payment-method-settings', App\Http\Controllers\Menu\Settings\PaymentMethodController::class)->only('index');
// Payment Methods Settings Index Route
Route::resource('/settings/payment-type-settings', App\Http\Controllers\Menu\Settings\PaymentTypeController::class)->only('index');
// Postcode Settings Load Datatables Route
Route::get('/settings/postcode-settings-dt', [App\Http\Controllers\Menu\Settings\Postcode\DatatableController::class, 'create'])->name('postcode-settings-dt.create');
// Postcode Settings Resource Routes
Route::resource('/settings/postcode-settings', App\Http\Controllers\Menu\Settings\Postcode\PostcodeController::class)->except('show');
// Priorities Settings Resource Routes
Route::resource('/settings/priority-settings', App\Http\Controllers\Menu\Settings\PriorityController::class)->except('show');
// Products Settings Resource Routes
Route::resource('/settings/product-settings', App\Http\Controllers\Menu\Settings\ProductController::class);
// Products Settings Resource Routes
Route::resource('/settings/product-image-settings', App\Http\Controllers\Menu\Settings\ProductImageController::class)->except('index', 'create');
// Quote Document Download Route
Route::resource('/settings/quote-document-download', App\Http\Controllers\Menu\Settings\DownloadQuoteDocumentController::class)->only('show');
// Quote Document Render In Browser Route
Route::resource('/settings/quote-document-render', App\Http\Controllers\Menu\Settings\ViewQuoteDocumentController::class)->only('show');
// Quote Document Settings Resource Routes
Route::resource('/settings/quote-document-settings', App\Http\Controllers\Menu\Settings\QuoteDocumentController::class);
// Quote Request Settings Resource Routes
Route::resource('/settings/quote-request-status-settings', App\Http\Controllers\Menu\Settings\QuoteRequestStatusController::class)->only('index');
// Quote Sent Status Settings Resource Routes
Route::resource('/settings/quote-sent-status-settings', App\Http\Controllers\Menu\Settings\QuoteSentStatusController::class)->except('show');
// Quote Statuses Settings Resource Routes
Route::resource('/settings/quote-status-settings', App\Http\Controllers\Menu\Settings\QuoteStatusController::class)->except('show');
// Rates Settings Resource Routes
Route::resource('/settings/rate-settings', App\Http\Controllers\Menu\Settings\RateController::class);
// Quote Statuses Settings Resource Routes
Route::resource('/settings/referral-settings', App\Http\Controllers\Menu\Settings\Referral\ReferralController::class)->except('show');
// Task Settings Load Datatables Route
Route::get('/settings/referral-settings-dt', [App\Http\Controllers\Menu\Settings\Referral\DatatableController::class, 'create'])->name('referral-settings-dt.create');
// Rates Settings Resource Routes
Route::resource('/settings/roof-pitch-factor-settings', App\Http\Controllers\Menu\Settings\RoofPitchMultiplyFactorController::class);
// Seo Keywords Routes
Route::resource('/settings/seo-keywords-settings', App\Http\Controllers\Menu\Settings\SeoKeywordController::class);
// Seo Tags Routes
Route::resource('/settings/seo-tags-settings', App\Http\Controllers\Menu\Settings\SeoTagController::class);
// SWMS Settings Questions Resource Routes
Route::resource('/settings/swms-questions-category-settings', App\Http\Controllers\Menu\Settings\SwmsQuestionCategoryController::class)->only('index', 'edit', 'update');
// SWMS Settings Questions Resource Routes
Route::resource('/settings/swms-questions-settings', App\Http\Controllers\Menu\Settings\SwmsQuestionController::class)->except('show');
// SWMS Settings Resource Routes
Route::resource('/settings/swms-settings', App\Http\Controllers\Menu\Settings\SwmsController::class)->except('store', 'destroy');
// Survey Settings Resource Routes
Route::resource('/settings/survey-settings', App\Http\Controllers\Menu\Settings\SurveyController::class)->except('create', 'store', 'destroy');
// Service Area Settings Resource Routes
Route::resource('/settings/service-area-settings', App\Http\Controllers\Menu\Settings\ServiceAreaController::class);
// Task Type Settings Resource Routes
Route::resource('/settings/task-type-settings', App\Http\Controllers\Menu\Settings\TaskTypeController::class);
// Task Settings Load Datatables Route
Route::get('/settings/task-settings-dt', [App\Http\Controllers\Menu\Settings\Task\DatatableController::class, 'create'])->name('task-settings-dt.create');
// Task Settings Resource Routes
Route::resource('/settings/task-settings', App\Http\Controllers\Menu\Settings\Task\TaskController::class);
// Task Range Settings Resource Routes
Route::resource('/settings/task-price-range-settings', App\Http\Controllers\Menu\Settings\TaskPriceRangeController::class)->only('index', 'update');
// User Logins Resource Routes
Route::resource('/settings/user-login-settings', App\Http\Controllers\Menu\Settings\UserLoginController::class)->only('index', 'show');

// Terms and Conditions Headings Routes
Route::resource('/settings/terms-and-conditions-headings', App\Http\Controllers\Menu\Settings\TermsAndConditions\HeadingController::class);
// Terms and Conditions Sub Headings Routes
Route::resource('/settings/terms-and-conditions-subheadings', App\Http\Controllers\Menu\Settings\TermsAndConditions\SubheadingController::class);
// Terms and Conditions Items Routes
Route::resource('/settings/terms-and-conditions-items', App\Http\Controllers\Menu\Settings\TermsAndConditions\ItemController::class);
// Terms and Conditions Sub Items Routes
Route::resource('/settings/terms-and-conditions-subitems', App\Http\Controllers\Menu\Settings\TermsAndConditions\SubitemController::class);
// Terms And Conditions Template Index Route
Route::resource('/settings/terms-and-conditions-template', App\Http\Controllers\Menu\Settings\TermsAndConditions\TemplateController::class)->only('index', 'create');
// Terms And Conditions Index Menu Route
Route::resource('/settings/terms-and-conditions', App\Http\Controllers\Menu\Settings\TermsAndConditions\TermsAndConditionsController::class)->only('index');

// Rounding calculator app Route
Route::resource('/settings/rounding-calculator', App\Http\Controllers\Menu\Settings\RoundingCalculator\CalculatorController::class)->only('index');

// Rounding calculator app Route
Route::resource('/settings/expected-payment-settings', App\Http\Controllers\Menu\Settings\ExpectedPaymentMethodController::class)->only('index');

// Settings
Route::resource('/settings', App\Http\Controllers\Menu\Settings\SettingsController::class)->only('index');


// QUOTE REMINDER REDIRECT ROUTES.
// Yes
Route::resource('/emails/quote-reminder-emails-r1', App\Http\Controllers\Manage\QuoteReminder\R1Controller::class)->only('show');
// Contact Me
Route::resource('/emails/quote-reminder-emails-r2', App\Http\Controllers\Manage\QuoteReminder\R2Controller::class)->only('show');
// Waiting
Route::resource('/emails/quote-reminder-emails-r3', App\Http\Controllers\Manage\QuoteReminder\R3Controller::class)->only('show');
// No
Route::resource('/emails/quote-reminder-emails-r4', App\Http\Controllers\Manage\QuoteReminder\R4Controller::class)->only('show');