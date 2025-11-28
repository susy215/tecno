<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Product;
use App\Models\Category;
use App\Models\Supplier;
use App\Models\Delivery;
use App\Models\Banner;
use Illuminate\Support\Str;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;


class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Khun Nat',
            'email' => 'admin1@gmail.com',
            'email_verified_at' => now(),
            'password' => ('password'),
            'remember_token' => Str::random(10),
        ])->assignRole('admin');
        User::create([
            'name' => 'Phoeut Ratana',
            'email' => 'rathana@gmail.com',
            'email_verified_at' => now(),
            'password' => ('password'),
            'remember_token' => Str::random(10),
        ])->assignRole('staff');

                // Proveedores
        Supplier::create([
            'name' => 'BeautyLux S.A.',
            'email' => 'contacto@beautylux.com',
            'number' => '0987 654 321',
            'address' => 'Santa Cruz, Bolivia',
        ]);

        Supplier::create([
            'name' => 'DermaCare Importaciones',
            'email' => 'ventas@dermacare.com',
            'number' => '0965 321 000',
            'address' => 'Cochabamba, Bolivia',
        ]);

        Supplier::create([
            'name' => 'NaturalSkin Proveedores',
            'email' => 'info@naturalskin.com',
            'number' => '0975 999 888',
            'address' => 'La Paz, Bolivia',
        ]);

                // Categorías adaptadas al contexto de belleza y cuidado personal
        Category::create([
            'category' => 'Cuidado de la Piel',
            'description' => "Productos para el cuidado facial y corporal, como cremas, lociones y limpiadores.",
        ]);

        Category::create([
            'category' => 'Maquillaje',
            'description' => "Productos cosméticos para el rostro, ojos y labios.",
        ]);

        Category::create([
            'category' => 'Cuidado del Cabello',
            'description' => "Champús, acondicionadores, tratamientos y aceites para el cabello.",
        ]);

        Category::create([
            'category' => 'Fragancias',
            'description' => "Perfumes, colonias y sprays corporales para hombres y mujeres.",
        ]);

        Category::create([
            'category' => 'Accesorios de Belleza',
            'description' => "Brochas, esponjas, espejos, pinzas y otros complementos para rutinas de belleza.",
        ]);

        Category::create([
            'category' => 'Higiene Personal',
            'description' => "Jabones, desodorantes, cremas de afeitar y productos de cuidado íntimo.",
        ]);

        Category::create([
            'category' => 'Cosmética Natural',
            'description' => "Productos hechos con ingredientes naturales y orgánicos.",
        ]);

        // Productos de belleza y cuidado de la piel
        Product::create([
            'title' => 'Crema Hidratante Facial Aloe Vera',
            'category_id' => '1',
            'supplier_id' => '1',
            'description' => "Crema hidratante con extracto de aloe vera para piel sensible. Nutre, hidrata y suaviza la piel del rostro.",
            'cost' => '8',
            'discount' => '0',
            'sellingprice' => '15',
            'price' => '15',
            'total_cost' => '80',
            'total_price' => '150',
            'qty'  => '10',
            'published' => 1
        ]);

        Product::create([
            'title' => 'Serum Antiarrugas Vitamina C',
            'category_id' => '1',
            'supplier_id' => '2',
            'description' => "Sérum facial con vitamina C y ácido hialurónico. Ilumina la piel, reduce líneas de expresión y mejora la textura.",
            'cost' => '12',
            'discount' => '2',
            'sellingprice' => '20',
            'price' => '18',
            'total_cost' => '120',
            'total_price' => '180',
            'qty'  => '10',
            'published' => 1
        ]);





        // Servicios de entrega
        Delivery::create([
            'company' => 'Envío Express Beauty',
            'description' => "Servicio rápido y seguro para productos cosméticos.",
        ]);

        Delivery::create([
            'company' => 'CosmoLogística',
            'description' => "Entrega especializada para productos de cuidado personal.",
        ]);

        Delivery::create([
            'company' => 'Belleza Delivery',
            'description' => "Transporte especializado para productos delicados de belleza.",
        ]);
        // Banner::create([
        //     'image' => 'banner_images/Shose Banner.jpg',
        //     'description'=>"None",
        // ]);
        // Banner::create([
        //     'image' => 'banner_images/Banner1.jpg',
        //     'description'=>"None",
        // ]);
        // Banner::create([
        //     'image' => 'banner_images/Fashion-sale-web-banner.jpg',
        //     'description'=>"None",
        // ]);
    }
}
