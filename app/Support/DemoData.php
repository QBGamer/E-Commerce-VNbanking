<?php

namespace App\Support;

/**
 * Hardcoded demo data used by the storefront & admin demo views.
 */
class DemoData
{
    /**
     * Return all demo datasets keyed for view sharing.
     */
    public static function data(): array
    {
        return [
            'storeInfo' => self::storeInfo(),
            'categories' => self::categories(),
            'products' => self::products(),
            'cartItems' => self::cartItems(),
            'orders' => self::orders(),
            'adminOrders' => self::adminOrders(),
            'adminCustomers' => self::adminCustomers(),
            'coupons' => self::coupons(),
        ];
    }

    public static function storeInfo(): array
    {
        return [
            'name' => 'ShopHub',
            'tagline' => 'Everything you need, delivered.',
            'email' => 'support@shophub.demo',
            'phone' => '+1 (555) 010-2030',
            'address' => '123 Market Street, District 1, Ho Chi Minh City, Vietnam',
        ];
    }

    public static function categories(): array
    {
        return [
            'electronics' => 'Electronics',
            'fashion' => 'Fashion',
            'home' => 'Home & Living',
            'beauty' => 'Beauty',
            'sports' => 'Sports & Outdoors',
        ];
    }

    public static function products(): array
    {
        return [
            ['id' => 1, 'slug' => 'wireless-headphones', 'name' => 'Wireless Headphones', 'category' => 'electronics', 'category_name' => 'Electronics', 'price' => 89.99, 'old_price' => 129.99, 'rating' => 4.5, 'reviews' => 1284, 'stock' => 42, 'image' => 'https://placehold.co/600x600/6366f1/ffffff?text=Headphones', 'badge' => 'Sale', 'description' => 'Premium over-ear wireless headphones with active noise cancellation, 40-hour battery life and rich, immersive sound.'],
            ['id' => 2, 'slug' => 'smart-watch', 'name' => 'Smart Watch Pro', 'category' => 'electronics', 'category_name' => 'Electronics', 'price' => 199.99, 'old_price' => 249.99, 'rating' => 4.6, 'reviews' => 892, 'stock' => 25, 'image' => 'https://placehold.co/600x600/8b5cf6/ffffff?text=Smart+Watch', 'badge' => 'New', 'description' => 'Track fitness, sleep and heart rate with a bright AMOLED display, GPS and 7-day battery life.'],
            ['id' => 3, 'slug' => 'leather-backpack', 'name' => 'Classic Leather Backpack', 'category' => 'fashion', 'category_name' => 'Fashion', 'price' => 74.50, 'old_price' => 99.00, 'rating' => 4.3, 'reviews' => 543, 'stock' => 18, 'image' => 'https://placehold.co/600x600/f59e0b/ffffff?text=Backpack', 'badge' => 'Sale', 'description' => 'Hand-crafted full-grain leather backpack with padded 15" laptop sleeve and brass hardware.'],
            ['id' => 4, 'slug' => 'denim-jacket', 'name' => 'Classic Denim Jacket', 'category' => 'fashion', 'category_name' => 'Fashion', 'price' => 62.00, 'old_price' => null, 'rating' => 4.2, 'reviews' => 310, 'stock' => 7, 'image' => 'https://placehold.co/600x600/0ea5e9/ffffff?text=Denim', 'badge' => 'Low Stock', 'description' => 'Timeless mid-wash denim jacket in 100% cotton, built to be your everyday layer.'],
            ['id' => 5, 'slug' => 'ceramic-cookware-set', 'name' => 'Ceramic Cookware Set', 'category' => 'home', 'category_name' => 'Home & Living', 'price' => 149.99, 'old_price' => 199.99, 'rating' => 4.7, 'reviews' => 765, 'stock' => 12, 'image' => 'https://placehold.co/600x600/10b981/ffffff?text=Cookware', 'badge' => 'Sale', 'description' => 'Non-stick ceramic cookware set of 10 pieces. Induction compatible, oven safe and easy to clean.'],
            ['id' => 6, 'slug' => 'aroma-diffuser', 'name' => 'Ultrasonic Aroma Diffuser', 'category' => 'home', 'category_name' => 'Home & Living', 'price' => 34.99, 'old_price' => null, 'rating' => 4.4, 'reviews' => 421, 'stock' => 60, 'image' => 'https://placehold.co/600x600/14b8a6/ffffff?text=Diffuser', 'badge' => null, 'description' => 'Quiet ultrasonic diffuser with 7 color moods and auto shut-off for a calm space.'],
            ['id' => 7, 'slug' => 'serum-vitamin-c', 'name' => 'Vitamin C Serum', 'category' => 'beauty', 'category_name' => 'Beauty', 'price' => 24.99, 'old_price' => 34.99, 'rating' => 4.8, 'reviews' => 2031, 'stock' => 8, 'image' => 'https://placehold.co/600x600/ec4899/ffffff?text=Serum', 'badge' => 'Trending', 'description' => 'Brightening 15% Vitamin C facial serum that evens skin tone and reduces dark spots.'],
            ['id' => 8, 'slug' => 'yoga-mat', 'name' => 'Non-Slip Yoga Mat', 'category' => 'sports', 'category_name' => 'Sports & Outdoors', 'price' => 29.99, 'old_price' => 39.99, 'rating' => 4.5, 'reviews' => 988, 'stock' => 35, 'image' => 'https://placehold.co/600x600/22c55e/ffffff?text=Yoga+Mat', 'badge' => 'Sale', 'description' => 'Extra-thick eco-friendly TPE yoga mat with alignment lines and carrying strap.'],
            ['id' => 9, 'slug' => 'mechanical-keyboard', 'name' => 'Mechanical Keyboard 75%', 'category' => 'electronics', 'category_name' => 'Electronics', 'price' => 119.00, 'old_price' => null, 'rating' => 4.9, 'reviews' => 1506, 'stock' => 3, 'image' => 'https://placehold.co/600x600/6366f1/ffffff?text=Keyboard', 'badge' => 'Low Stock', 'description' => 'Hot-swappable 75% mechanical keyboard with gasket mount and RGB backlighting.'],
            ['id' => 10, 'slug' => 'running-shoes', 'name' => 'Lightweight Running Shoes', 'category' => 'sports', 'category_name' => 'Sports & Outdoors', 'price' => 95.00, 'old_price' => 120.00, 'rating' => 4.4, 'reviews' => 732, 'stock' => 20, 'image' => 'https://placehold.co/600x600/ef4444/ffffff?text=Shoes', 'badge' => 'Sale', 'description' => 'Breathable knit running shoes with responsive foam soles for all-day comfort.'],
            ['id' => 11, 'slug' => 'sunglasses', 'name' => 'Aviator Sunglasses', 'category' => 'fashion', 'category_name' => 'Fashion', 'price' => 45.00, 'old_price' => null, 'rating' => 4.1, 'reviews' => 208, 'stock' => 55, 'image' => 'https://placehold.co/600x600/0ea5e9/ffffff?text=Sunglasses', 'badge' => null, 'description' => 'Classic aviator sunglasses with polarized UV400 lenses and metal frame.'],
            ['id' => 12, 'slug' => 'skincare-gift-set', 'name' => 'Skincare Gift Set', 'category' => 'beauty', 'category_name' => 'Beauty', 'price' => 69.99, 'old_price' => 85.00, 'rating' => 4.7, 'reviews' => 456, 'stock' => 0, 'image' => 'https://placehold.co/600x600/ec4899/ffffff?text=Gift+Set', 'badge' => 'Sold Out', 'description' => 'Curated set of cleanser, toner, moisturizer and eye cream for a full routine.'],
        ];
    }

    public static function cartItems(): array
    {
        $products = self::products();

        return [
            ['product' => $products[0], 'qty' => 1],
            ['product' => $products[2], 'qty' => 2],
            ['product' => $products[4], 'qty' => 1],
        ];
    }

    public static function orders(): array
    {
        return [
            ['id' => 'ORD-1082', 'date' => '2026-09-10', 'status' => 'Delivered', 'total' => 158.47, 'items' => 3, 'payment' => 'Credit Card'],
            ['id' => 'ORD-1081', 'date' => '2026-09-05', 'status' => 'Shipped', 'total' => 89.99, 'items' => 1, 'payment' => 'PayPal'],
            ['id' => 'ORD-1080', 'date' => '2026-08-28', 'status' => 'Processing', 'total' => 214.98, 'items' => 2, 'payment' => 'VNPay'],
            ['id' => 'ORD-1079', 'date' => '2026-08-19', 'status' => 'Cancelled', 'total' => 45.00, 'items' => 1, 'payment' => 'Credit Card'],
        ];
    }

    public static function adminOrders(): array
    {
        return [
            ['id' => 'ORD-1082', 'customer' => 'Alice Nguyen', 'date' => '2026-09-12', 'total' => 158.47, 'items' => 3, 'status' => 'Pending', 'payment' => 'VNPay'],
            ['id' => 'ORD-1081', 'customer' => 'Brian Tran', 'date' => '2026-09-12', 'total' => 89.99, 'items' => 1, 'status' => 'Processing', 'payment' => 'Credit Card'],
            ['id' => 'ORD-1080', 'customer' => 'Chi Le', 'date' => '2026-09-11', 'total' => 214.98, 'items' => 2, 'status' => 'Shipped', 'payment' => 'PayPal'],
            ['id' => 'ORD-1079', 'customer' => 'Duy Pham', 'date' => '2026-09-11', 'total' => 45.00, 'items' => 1, 'status' => 'Delivered', 'payment' => 'Credit Card'],
            ['id' => 'ORD-1078', 'customer' => 'Emily Vo', 'date' => '2026-09-10', 'total' => 129.98, 'items' => 2, 'status' => 'Delivered', 'payment' => 'VNPay'],
            ['id' => 'ORD-1077', 'customer' => 'Frank Hoang', 'date' => '2026-09-09', 'total' => 62.00, 'items' => 1, 'status' => 'Delivered', 'payment' => 'PayPal'],
            ['id' => 'ORD-1076', 'customer' => 'Giang Dang', 'date' => '2026-09-08', 'total' => 249.00, 'items' => 4, 'status' => 'Cancelled', 'payment' => 'Credit Card'],
        ];
    }

    public static function adminCustomers(): array
    {
        return [
            ['id' => 1, 'name' => 'Alice Nguyen', 'email' => 'alice@example.com', 'orders' => 12, 'spent' => 1248.50, 'status' => 'Active', 'joined' => '2025-11-02'],
            ['id' => 2, 'name' => 'Brian Tran', 'email' => 'brian@example.com', 'orders' => 8, 'spent' => 832.20, 'status' => 'Active', 'joined' => '2026-01-15'],
            ['id' => 3, 'name' => 'Chi Le', 'email' => 'chi@example.com', 'orders' => 5, 'spent' => 412.75, 'status' => 'Active', 'joined' => '2026-03-08'],
            ['id' => 4, 'name' => 'Duy Pham', 'email' => 'duy@example.com', 'orders' => 3, 'spent' => 220.10, 'status' => 'Inactive', 'joined' => '2026-04-22'],
            ['id' => 5, 'name' => 'Emily Vo', 'email' => 'emily@example.com', 'orders' => 15, 'spent' => 1930.00, 'status' => 'Active', 'joined' => '2025-09-30'],
            ['id' => 6, 'name' => 'Frank Hoang', 'email' => 'frank@example.com', 'orders' => 2, 'spent' => 98.00, 'status' => 'Inactive', 'joined' => '2026-06-11'],
        ];
    }

    public static function coupons(): array
    {
        return [
            ['code' => 'WELCOME10', 'type' => 'Percent', 'value' => 10, 'min' => 20.00, 'uses' => 812, 'expires' => '2026-12-31', 'status' => 'Active'],
            ['code' => 'SAVE20', 'type' => 'Percent', 'value' => 20, 'min' => 100.00, 'uses' => 344, 'expires' => '2026-11-15', 'status' => 'Active'],
            ['code' => 'FREESHIP', 'type' => 'Shipping', 'value' => 0, 'min' => 50.00, 'uses' => 1020, 'expires' => '2026-10-01', 'status' => 'Active'],
            ['code' => 'FLASH50', 'type' => 'Fixed', 'value' => 50, 'min' => 300.00, 'uses' => 58, 'expires' => '2026-09-20', 'status' => 'Expired'],
            ['code' => 'VIP100', 'type' => 'Fixed', 'value' => 100, 'min' => 500.00, 'uses' => 12, 'expires' => '2026-12-15', 'status' => 'Active'],
        ];
    }
}
