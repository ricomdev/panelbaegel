<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\IndexController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\SubcategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductBoxSController;
use App\Http\Controllers\ProductBoxMController;
use App\Http\Controllers\ProductBrunchBoxController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DistrictController;
use App\Http\Controllers\TestimonialController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\SliderController;
use App\Http\Controllers\OurStoryController;
use App\Http\Controllers\TimelineEventController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\InstagramTileController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\IndexAdminController;
use App\Http\Controllers\HomeHeaderController;
use App\Http\Controllers\HomeBagelController;
use App\Http\Controllers\FooterController;
use App\Http\Controllers\FaqController;
use App\Http\Controllers\CateringController;
use App\Http\Controllers\HomeStoryBlockController;
use App\Http\Controllers\DiscountController;
use App\Http\Controllers\OnlyuserController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\SalesController;
use App\Http\Controllers\MailingController;
use App\Http\Controllers\BloqueoTurnosController;
use App\Http\Controllers\PrivacyPolicyController;
use App\Http\Controllers\TermsConditionsController;

Route::middleware('auth')->get('/', [IndexAdminController::class, 'index'])->name('panel.index');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware('auth')->group(function () {
    Route::get('/categories', [CategoryController::class, 'index'])->name('category.index');
    Route::get('/category/edit/{code}', [CategoryController::class, 'show'])->name('category.show');
    Route::get('/datacategory/{code}', [CategoryController::class, 'datacategory'])->name('category.datacategory');
    Route::post('/updatecategory/{code}', [CategoryController::class, 'updatecategory'])->name('category.updatecategory');
    Route::delete('/category/image/{id}', [CategoryController::class, 'deleteImage']);

    Route::get('/subcategories', [SubcategoryController::class, 'index'])->name('subcategory.index');
    Route::get('/subcategory/edit/{code}', [SubcategoryController::class, 'show'])->name('subcategory.show');
    Route::get('/datasubcategory/{code}', [SubcategoryController::class, 'datasubcategory'])->name('subcategory.datacategory');
    Route::post('/updatesubcategory/{code}', [SubcategoryController::class, 'updatesubcategory'])->name('subcategory.updatecategory');
    Route::delete('/subcategory/image/{id}', [SubcategoryController::class, 'deleteImage']);

    // =======================
    // Productos Unitarios
    // ======================
    Route::get('/products/unit', [ProductController::class, 'indexUnit'])->name('product.unit.index');
    Route::get('/product/unit/create', [ProductController::class, 'createUnit'])->name('product.unit.create');
    Route::post('/product/unit/store', [ProductController::class, 'storeUnit'])->name('product.unit.store');
    Route::get('/product/unit/edit/{code}', [ProductController::class, 'showUnit'])->name('product.unit.show');
    Route::get('/dataproduct/unit/{code}', [ProductController::class, 'dataproductUnit'])->name('product.unit.dataproduct');
    Route::post('/updateproduct/unit/{code}', [ProductController::class, 'updateUnit'])->name('product.unit.update');
    Route::delete('/product/unit/image/{id}', [ProductController::class, 'deleteUnitImage'])->name('product.image.delete');
    Route::get('/product/unit/check-code/{code}', [ProductController::class, 'checkUnitCode'])->name('product.unit.checkcode');


 
    // =======================
    // PRODUCTOS BOX-S (box3s y box6s)
    // ======================
    Route::get('/products/boxs', [ProductBoxSController::class, 'index'])->name('product.boxs.index');
    Route::get('/product/boxs/create', [ProductBoxSController::class, 'create'])->name('product.boxs.create');
    Route::post('/product/boxs/store', [ProductBoxSController::class, 'store'])->name('product.boxs.store');
    Route::get('/product/boxs/edit/{code}', [ProductBoxSController::class, 'show'])->name('product.boxs.show');
    Route::get('/dataproduct/boxs/{code}', [ProductBoxSController::class, 'dataproduct'])->name('product.boxs.dataproduct');
    Route::post('/updateproduct/boxs/{code}', [ProductBoxSController::class, 'update'])->name('product.boxs.update');
    Route::delete('/product/boxs/image/{id}', [ProductBoxSController::class, 'deleteImage'])->name('product.boxs.deleteimage');
    Route::get('/products/boxs/units-by-subcategory/{subcategory_id}', [ProductBoxSController::class, 'getUnitsBySubcategory'])->name('product.boxs.getunits');
    Route::get('/product/boxs/check-code/{code}', [ProductBoxSController::class, 'checkCode'])->name('product.boxs.checkcode');


    // =======================
    // RUTAS PRODUCTOS BOXM
    // =======================
    Route::get('/products/boxm', [ProductBoxMController::class, 'index'])->name('product.boxm.index');
    Route::get('/product/boxm/create', [ProductBoxMController::class, 'create'])->name('product.boxm.create');
    Route::post('/product/boxm/store', [ProductBoxMController::class, 'store'])->name('product.boxm.store');
    Route::get('/product/boxm/edit/{code}', [ProductBoxMController::class, 'show'])->name('product.boxm.show');
    Route::get('/dataproduct/boxm/{code}', [ProductBoxMController::class, 'dataproduct'])->name('product.boxm.dataproduct');
    Route::post('/updateproduct/boxm/{code}', [ProductBoxMController::class, 'update'])->name('product.boxm.update');
    Route::delete('/product/boxm/image/{id}', [ProductBoxMController::class, 'deleteImage']);
    Route::get('/product/boxm/check-code/{code}', [ProductBoxMController::class, 'checkCode'])->name('product.boxm.checkcode');

    // =====================
    // RUTAS PRODUCT BRUNCH BOX
    // =============================
    Route::get('/products/brunch', [ProductBrunchBoxController::class, 'index'])->name('product.brunch.index');
    Route::get('/product/brunch/create', [ProductBrunchBoxController::class, 'create'])->name('product.brunch.create');
    Route::post('/product/brunch/store', [ProductBrunchBoxController::class, 'store'])->name('product.brunch.store');
    Route::get('/product/brunch/edit/{code}', [ProductBrunchBoxController::class, 'show'])->name('product.brunch.show');
    Route::get('/dataproduct/brunch/{code}', [ProductBrunchBoxController::class, 'dataproduct'])->name('product.brunch.dataproduct');
    Route::post('/updateproduct/brunch/{code}', [ProductBrunchBoxController::class, 'update'])->name('product.brunch.update');
    Route::delete('/product/brunch/image/{id}', [ProductBrunchBoxController::class, 'deleteImage'])->name('product.brunch.deleteimage');
    Route::get('/product/brunch/check-code/{code}', [ProductBrunchBoxController::class, 'checkCode'])->name('product.brunch.checkcode');
    

    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{id}', [OrderController::class, 'show'])->name('orders.show');

    Route::get('/users', [UserController::class, 'index'])->name('user.index');

    Route::get('/testimonials', [TestimonialController::class, 'index'])->name('testimonial.index');
    Route::post('/updatetestimonial', [TestimonialController::class, 'updatetestimonial'])->name('testimonial.updatetestimonial');

    Route::get('/districts', [DistrictController::class, 'index'])->name('districts.index');
    Route::post('/districts/update/{id}', [DistrictController::class, 'update'])->name('districts.update');
    Route::delete('/districts/{id}', [DistrictController::class, 'destroy'])->name('districts.destroy');
    Route::get('/districts/create', [DistrictController::class, 'create'])->name('districts.create');
    Route::get('/districts/{district}', [DistrictController::class, 'show'])->name('districts.show');
    Route::post('/districts', [DistrictController::class, 'store'])->name('districts.store');


    // ------------------------
    // HOME HEADERS
    // ------------------------
    Route::put('/home-header', [HomeHeaderController::class, 'update'])->name('home-header.update');


    // ------------------------
    // HOME BAGELS
    // ------------------------
    Route::get('/home-bagels', [HomeBagelController::class, 'index'])->name('home-bagels.index');
    Route::post('/home-bagels', [HomeBagelController::class, 'store'])->name('home-bagels.store');
    Route::put('/home-bagels/{id}', [HomeBagelController::class, 'update'])->name('home-bagels.update');
    Route::delete('/home-bagels/{id}', [HomeBagelController::class, 'destroy'])->name('home-bagels.destroy');

    // ------------------------
    // SLIDERS
    // ------------------------
    Route::resource('sliders', SliderController::class)->except(['show', 'create', 'edit']);

    // ------------------------
    // OUR STORY
    // ------------------------
    Route::resource('our-story', OurStoryController::class)->only(['index', 'edit', 'update']);

    // ------------------------
    // TIMELINE EVENTS
    // ------------------------
    Route::resource('timeline-events', TimelineEventController::class)->only(['update']);

    // ------------------------
    // BRANDS
    // ------------------------
    Route::resource('brands', BrandController::class)->except(['show']);

    // ===============================
    // SERVICES (3 fijos)
    // ===============================
    Route::get('/services', [ServiceController::class, 'index'])->name('services.index');
    Route::put('/services/order/{order}', [ServiceController::class, 'updateByOrder'])->name('services.updateByOrder');

    // ------------------------
    // INSTAGRAM TILES
    // ------------------------
    Route::put('/instagram-tiles/order/{order}', [InstagramTileController::class, 'updateByOrder'])->name('instagram.updateByOrder');


    // ------------------------
    // SITE SETTINGS
    // ------------------------
    Route::get('/settings', [SettingController::class, 'index'])->name('settings.index');
    Route::put('/settings', [SettingController::class, 'update'])->name('settings.update');

    // PANEL: FOOTER
    Route::get('/footer', [FooterController::class, 'index'])->name('footer.index');
    Route::post('/footer/update-settings', [FooterController::class, 'updateSettings'])->name('footer.updateSettings');

    // Redes sociales
    Route::post('/footer/socials', [FooterController::class, 'storeSocial'])->name('footer.socials.store');
    Route::post('/footer/socials/{id}', [FooterController::class, 'updateSocial'])->name('footer.socials.update');
    Route::delete('/footer/socials/{id}', [FooterController::class, 'destroySocial'])->name('footer.socials.destroy');

    // Panel de administración de FAQs
    Route::prefix('faqs')->group(function () {
        Route::get('/', [FaqController::class, 'index'])->name('faqs.index');

        // Categorías
        Route::post('/categories', [FaqController::class, 'storeCategory']);
        Route::put('/categories/{id}', [FaqController::class, 'updateCategory']);
        Route::delete('/categories/{id}', [FaqController::class, 'destroyCategory']);

        // Preguntas
        Route::post('/questions', [FaqController::class, 'storeFaq']);
        Route::put('/questions/{id}', [FaqController::class, 'updateFaq']);
        Route::delete('/questions/{id}', [FaqController::class, 'destroyFaq']);
    });

    // Panel de administración de Políticas de Privacidad
    Route::prefix('privacy-policies')->group(function () {
        Route::get('/', [PrivacyPolicyController::class, 'index'])->name('privacy.index');

        // Texto general
        Route::post('/general/store', [PrivacyPolicyController::class, 'storeGeneral']);
        Route::put('/general/{id}', [PrivacyPolicyController::class, 'updateGeneral']);

        // Secciones de políticas
        Route::post('/store', [PrivacyPolicyController::class, 'storePolicy']);
        Route::put('/{id}', [PrivacyPolicyController::class, 'updatePolicy']);
        Route::delete('/{id}', [PrivacyPolicyController::class, 'destroyPolicy']);
    });

    // Panel de administración de Términos y Condiciones
    Route::prefix('terms-conditions')->group(function () {
        Route::get('/', [TermsConditionsController::class, 'index'])->name('terms.index');

        // Texto general
        Route::post('/general/store', [TermsConditionsController::class, 'storeGeneral']);
        Route::put('/general/{id}', [TermsConditionsController::class, 'updateGeneral']);

        // Secciones de términos
        Route::post('/store', [TermsConditionsController::class, 'storeTerm']);
        Route::put('/{id}', [TermsConditionsController::class, 'updateTerm']);
        Route::delete('/{id}', [TermsConditionsController::class, 'destroyTerm']);
    });



    // Vista principal del panel de Catering
    Route::get('/catering', [CateringController::class, 'index'])->name('catering.index');

    // Actualizar contenido
    Route::post('/catering/update', [CateringController::class, 'update'])->name('catering.update');

    Route::get('home-story-blocks', [HomeStoryBlockController::class, 'index'])->name('home_story_blocks.index');
    Route::post('home-story-blocks/update/{id}', [HomeStoryBlockController::class, 'update'])->name('home_story_blocks.update');

    Route::get('/sales', [SalesController::class, 'index'])->name('sales.index');

    Route::get('/discounts', [DiscountController::class, 'index'])->name('discount.index');
    Route::get('/discount/edit/{codigo}', [DiscountController::class, 'show'])->name('discount.show');
    Route::get('/discount/create', [DiscountController::class, 'create'])->name('discount.create');
    Route::get('/datadiscount/{codigo}', [DiscountController::class, 'datadiscount'])->name('discount.datadiscount');
    Route::post('/creatediscount', [DiscountController::class, 'creatediscount'])->name('discount.creatediscount');
    Route::post('/updatediscount/{codigo}', [DiscountController::class, 'updatediscount'])->name('discount.updatediscount');
    Route::get('/checkcodediscount/{codigo}', [DiscountController::class, 'checkcodediscount'])->name('discount.checkcodediscount');
    Route::get('/deletediscount/{codigo}', [DiscountController::class, 'deletediscount'])->name('discount.deletediscount');

    Route::get('/dataonlyuser', [OnlyuserController::class, 'data'])->name('onlyuser.data');

    Route::get('/reports/orders', [ReportController::class, 'ordersIndex'])->name('reports.orders.index');
    Route::get('/reports/orders/export', [ReportController::class, 'ordersExport'])->name('reports.orders.export');

    Route::get('/mailing-settings', [MailingController::class, 'mailingHeaderImage'])->name('mailing.header_image');
    Route::post('/mailing-settings/update', [MailingController::class, 'updateMAilingHeaderImage'])->name('mailing.header_image.update');


    Route::get('/bloqueo-turnos', [BloqueoTurnosController::class, 'index'])->name('bloqueo-turnos.index');
    Route::post('/bloqueo-turnos/guardar', [BloqueoTurnosController::class, 'guardar'])->name('bloqueo-turnos.guardar');
    Route::get('/bloqueo-turnos/listar', [BloqueoTurnosController::class, 'listar'])->name('bloqueo-turnos.listar');
    Route::delete('/bloqueo-turnos/eliminar/{id}', [BloqueoTurnosController::class, 'eliminar'])->name('bloqueo-turnos.eliminar');
    
});



Route::get('/clear-cache', function() {
    $exitCode = Artisan::call('config:cache');
    return 'DONE'; //Return anything
});


require __DIR__.'/auth.php';
