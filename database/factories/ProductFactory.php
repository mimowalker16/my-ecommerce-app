<?php  

namespace Database\Factories;  

use Illuminate\Database\Eloquent\Factories\Factory;  

/**  
     * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>  
     */  
    class ProductFactory extends Factory  
    {  
        /**  
         * Define the model's default state.  
         *  
         * @return array<string, mixed>  
         */  
        public function definition(): array  
        {  
            // Real products for each category
            $products = [
                // Electronics
                [
                    'name' => 'Apple MacBook Air M3',
                    'description' => 'Experience the power of Apple Silicon with the ultra-light, ultra-fast MacBook Air M3. Perfect for work, creativity, and entertainment on the go.',
                    'price' => 1299.00,
                    'stock_quantity' => 40,
                    'category' => 'Electronics',
                    'image_url' => 'https://store.storeimages.cdn-apple.com/4982/as-images.apple.com/is/macbook-air-13-m3-hero-202402?wid=904&hei=840&fmt=jpeg&qlt=90&.v=1707338574182',
                ],
                [
                    'name' => 'Samsung Galaxy S24 Ultra',
                    'description' => 'The latest flagship smartphone from Samsung with a stunning display, pro-grade camera, and all-day battery life.',
                    'price' => 1199.99,
                    'stock_quantity' => 50,
                    'category' => 'Electronics',
                    'image_url' => 'https://images.samsung.com/is/image/samsung/p6pim/levant/2401/gallery/levant-galaxy-s24-ultra-sm-s928bzkgmea-thumb-539678237',
                ],
                // Beauty
                [
                    'name' => 'Dyson Airwrap Multi-Styler',
                    'description' => 'Achieve salon-quality hair at home with the Dyson Airwrap. Curl, wave, smooth, and dry with no extreme heat.',
                    'price' => 599.99,
                    'stock_quantity' => 25,
                    'category' => 'Beauty',
                    'image_url' => 'https://dyson-h.assetsadobe2.com/is/image/content/dam/dyson/images/products/primary/400714-01.png',
                ],
                [
                    'name' => 'Olaplex No. 3 Hair Perfector',
                    'description' => 'A cult-favorite hair treatment that repairs and strengthens all hair types.',
                    'price' => 30.00,
                    'stock_quantity' => 100,
                    'category' => 'Beauty',
                    'image_url' => 'https://www.sephora.com/productimages/sku/s2031362-main-zoom.jpg',
                ],
                // Fitness
                [
                    'name' => 'Theragun PRO Plus',
                    'description' => 'Relieve muscle tension and recover faster with the Theragun PRO Plus, the most advanced percussive therapy device for athletes and wellness seekers.',
                    'price' => 599.00,
                    'stock_quantity' => 30,
                    'category' => 'Fitness',
                    'image_url' => 'https://www.therabody.com/on/demandware.static/-/Sites-therabody-master-catalog/default/dw7e2e6e2e/images/hi-res/PROPlus-hero.png',
                ],
                [
                    'name' => 'Peloton Bike+',
                    'description' => 'The ultimate indoor cycling experience with immersive classes and a rotating HD touchscreen.',
                    'price' => 2495.00,
                    'stock_quantity' => 15,
                    'category' => 'Fitness',
                    'image_url' => 'https://s7d1.scene7.com/is/image/dmqualcomm/2021-01-14-peloton-bike-plus-hero',
                ],
                // Gaming
                [
                    'name' => 'Nintendo Switch OLED',
                    'description' => 'Play your favorite games anywhere with the vibrant Nintendo Switch OLED. Enhanced screen, improved audio, and endless fun for all ages.',
                    'price' => 349.99,
                    'stock_quantity' => 60,
                    'category' => 'Gaming',
                    'image_url' => 'https://assets.nintendo.com/image/upload/f_auto/q_auto/dpr_2.0/c_scale,w_400/ncom/en_US/switch/site-design-update/oled-model/gallery/oled-model-gallery-01',
                ],
                [
                    'name' => 'PlayStation 5 Console',
                    'description' => 'Sony’s next-gen PlayStation 5 delivers lightning-fast loading, stunning graphics, and a new generation of gaming.',
                    'price' => 499.99,
                    'stock_quantity' => 35,
                    'category' => 'Gaming',
                    'image_url' => 'https://m.media-amazon.com/images/I/619BkvKW35L._AC_SL1500_.jpg',
                ],
                // Home & Kitchen
                [
                    'name' => 'Stanley Quencher H2.0 FlowState Tumbler',
                    'description' => 'Stay hydrated in style with the viral Stanley Quencher. Keeps drinks cold for 11 hours and fits perfectly in your car cup holder.',
                    'price' => 45.00,
                    'stock_quantity' => 100,
                    'category' => 'Home & Kitchen',
                    'image_url' => 'https://cdn.shopify.com/s/files/1/0273/5387/8213/products/stanley-quencher-h2-0-flowstate-tumbler-40-oz-rose-quartz-1_800x.jpg',
                ],
                [
                    'name' => 'Caraway Nonstick Ceramic Cookware Set',
                    'description' => 'Upgrade your kitchen with Caraway’s stylish, non-toxic ceramic cookware. Nonstick, easy to clean, and Instagram-worthy.',
                    'price' => 395.00,
                    'stock_quantity' => 20,
                    'category' => 'Home & Kitchen',
                    'image_url' => 'https://cdn.carawayhome.com/images/products/cookware-sets/cookware-set-cream-hero.png',
                ],
                // Wearables
                [
                    'name' => 'Oura Ring Gen3',
                    'description' => 'Track your sleep, activity, and recovery with the sleek Oura Ring Gen3. The most advanced health wearable in a stylish, discreet form.',
                    'price' => 299.00,
                    'stock_quantity' => 50,
                    'category' => 'Wearables',
                    'image_url' => 'https://ouraring.com/cdn/shop/products/heritage-silver-1_1200x.png',
                ],
                [
                    'name' => 'Apple Watch Series 9',
                    'description' => 'The latest Apple Watch with advanced health sensors, crash detection, and a brilliant always-on display.',
                    'price' => 399.00,
                    'stock_quantity' => 70,
                    'category' => 'Wearables',
                    'image_url' => 'https://store.storeimages.cdn-apple.com/4982/as-images.apple.com/is/MQKX3_VW_34FR+watch-case-45-alum-silver-nc-9s_VW_34FR_WF_CO_GEO_US?wid=2000&hei=2000&fmt=jpeg&qlt=95&.v=1693346858577,1693501347272',
                ],
                // Gifts
                [
                    'name' => 'LEGO Icons Flower Bouquet',
                    'description' => 'A unique, everlasting gift: build and display a beautiful bouquet of LEGO flowers. Perfect for home decor or gifting.',
                    'price' => 59.99,
                    'stock_quantity' => 80,
                    'category' => 'Gifts',
                    'image_url' => 'https://www.lego.com/cdn/cs/set/assets/blt1e2e2e2e2e2e2e2e/10280.png',
                ],
                [
                    'name' => 'Yankee Candle Large Jar',
                    'description' => 'Fill your home with the comforting scent of Yankee Candle’s best-selling fragrances.',
                    'price' => 28.00,
                    'stock_quantity' => 120,
                    'category' => 'Gifts',
                    'image_url' => 'https://www.yankeecandle.com/dw/image/v2/BBRC_PRD/on/demandware.static/-/Sites-yankee-master-catalog/default/dw2e2e2e2e/images/large-jar-candles/1629966e.jpg',
                ],
                // Outdoors
                [
                    'name' => 'YETI Roadie 24 Cooler',
                    'description' => 'Keep your drinks and snacks ice-cold for days with the ultra-durable YETI Roadie 24. Perfect for road trips, camping, and tailgates.',
                    'price' => 250.00,
                    'stock_quantity' => 35,
                    'category' => 'Outdoors',
                    'image_url' => 'https://yeti-web.imgix.net/163837-roadie-24-cooler-white-1.png',
                ],
                [
                    'name' => 'Coleman Sundome Camping Tent',
                    'description' => 'A best-selling, easy-to-set-up tent for weekend camping adventures.',
                    'price' => 99.99,
                    'stock_quantity' => 60,
                    'category' => 'Outdoors',
                    'image_url' => 'https://m.media-amazon.com/images/I/81QwQZ4QJwL._AC_SL1500_.jpg',
                ],
                // Audio
                [
                    'name' => 'Bose QuietComfort Ultra Earbuds',
                    'description' => 'Immerse yourself in music with Bose’s best noise-cancelling earbuds. Crystal-clear calls, all-day comfort, and legendary sound.',
                    'price' => 299.00,
                    'stock_quantity' => 70,
                    'category' => 'Audio',
                    'image_url' => 'https://assets.bose.com/content/dam/Bose_DAM/Web/consumer_electronics/global/products/headphones/quietcomfort-ultra-earbuds/product_silo_images/qc_ueb_triple_black_EC_hero.psd/jcr:content/renditions/cq5dam.web.320.320.png',
                ],
                [
                    'name' => 'Sony WH-1000XM5 Headphones',
                    'description' => 'Industry-leading noise cancellation, crystal-clear sound, and all-day comfort from Sony.',
                    'price' => 399.99,
                    'stock_quantity' => 45,
                    'category' => 'Audio',
                    'image_url' => 'https://m.media-amazon.com/images/I/71o8Q5XJS5L._AC_SL1500_.jpg',
                ],
                // Footwear
                [
                    'name' => 'Allbirds Wool Runners',
                    'description' => 'Step into comfort and sustainability with Allbirds Wool Runners. Lightweight, breathable, and made from natural materials.',
                    'price' => 110.00,
                    'stock_quantity' => 90,
                    'category' => 'Footwear',
                    'image_url' => 'https://cdn.allbirds.com/image/upload/f_auto,q_auto,w_600/v1/production/products/images/sku/SHMNGM/primary/1.png',
                ],
                [
                    'name' => 'Nike Air Force 1',
                    'description' => 'The iconic Nike Air Force 1 delivers classic style and all-day comfort.',
                    'price' => 115.00,
                    'stock_quantity' => 100,
                    'category' => 'Footwear',
                    'image_url' => 'https://static.nike.com/a/images/t_PDP_864_v1/f_auto,q_auto:eco/1c6b2e2e-2e2e-4e2e-8e2e-2e2e2e2e2e2e/air-force-1-07-shoe.png',
                ],
                // Books & Media
                [
                    'name' => 'Kindle Paperwhite Signature Edition',
                    'description' => 'Read anywhere, anytime with the Kindle Paperwhite Signature Edition. Wireless charging, auto-adjusting light, and a glare-free display.',
                    'price' => 189.99,
                    'stock_quantity' => 55,
                    'category' => 'Books & Media',
                    'image_url' => 'https://m.media-amazon.com/images/I/61v5ZpFVQwL._AC_SL1000_.jpg',
                ],
                [
                    'name' => 'The Midnight Library by Matt Haig',
                    'description' => 'A bestselling novel about choices, regrets, and second chances.',
                    'price' => 13.99,
                    'stock_quantity' => 200,
                    'category' => 'Books & Media',
                    'image_url' => 'https://images.penguinrandomhouse.com/cover/9780525559474',
                ],
                // Photography
                [
                    'name' => 'Fujifilm Instax Mini 12',
                    'description' => 'Capture memories instantly with the Fujifilm Instax Mini 12. Fun, easy-to-use, and perfect for parties and travel.',
                    'price' => 79.99,
                    'stock_quantity' => 65,
                    'category' => 'Photography',
                    'image_url' => 'https://assets.fujifilm.com/image/upload/c_pad,dpr_2.0,f_auto,h_600,q_auto,w_600/v1/US/products/instant-photo/instax/mini-12/mini-12-lilac-purple-front.png',
                ],
                [
                    'name' => 'Canon EOS R50 Mirrorless Camera',
                    'description' => 'A compact, lightweight mirrorless camera with advanced autofocus and 4K video.',
                    'price' => 679.00,
                    'stock_quantity' => 20,
                    'category' => 'Photography',
                    'image_url' => 'https://m.media-amazon.com/images/I/81QwQZ4QJwL._AC_SL1500_.jpg',
                ],
            ];
            return fake()->randomElement($products);
        }  
    }