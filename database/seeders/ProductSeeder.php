<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('products')->insert([
            [
                'category_id'   => 1,
                'brand_id'      => 1,
                'name'          => 'Giày Samba ORIGINALS',
                'description'   => '<p>Đôi giày chạy bộ BOOST thế hệ mới có sử dụng chất liệu tái chế.
                                    Chinh phục kỷ lục cá nhân mới thật dễ dàng với đôi giày chạy bộ adidas này. Đế BOOST nhẹ nhất từ trước 
                                    đến nay của chúng tôi hoàn trả năng lượng liên tục trên từng cây số để bạn cảm thấy sung sức từ đầu đến
                                    cuối buổi chạy. Hệ thống Torsion System giữa gót giày và mũi giày tạo độ ổn định, cho sải bước mượt mà,
                                    vững chãi bất kể cự ly hay tốc độ nào. Tất cả được đặt trên đế ngoài Continental™ Rubber với độ bám chắc
                                    chắn cả trong điều kiện khô ráo cũng như ẩm ướt để bạn luôn tự tin sải bước. Sản phẩm này có chứa tối thiểu
                                        20% chất liệu tái chế. Bằng cách tái sử dụng các chất liệu đã được tạo ra, chúng tôi góp phần giảm thiểu lãng
                                        phí và hạn chế phụ thuộc vào các nguồn tài nguyên hữu hạn, cũng như giảm phát thải từ các sản phẩm mà chúng tôi
                                        sản xuất.</p>',
                'discount'      => 2,
                'sku'           => 'ADD21335',
                'featured'      => 1,
                'view'          => 150,
                'sales_count'   => 30,
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now(),
            ],
            [
                'category_id'   => 1,
                'brand_id'      => 1,
                'name'          => 'Giày Samba OG',
                'description'   => '<p>SAMBA ORIGINALS
                                    Ra đời trên sân bóng, giày Samba là biểu tượng kinh điển của phong cách đường phố. 
                                    Phiên bản này trung thành với di sản, thể hiện qua thân giày bằng da mềm, dáng thấp,
                                    nhã nhặn, các chi tiết phủ ngoài bằng da lộn và đế gum, biến đôi giày trở thành item
                                    không thể thiếu trong tủ đồ của tất cả mọi người - cả trong và ngoài sân cỏ.</p>',
                'discount'      => 2,
                'sku'           => 'QJN67890',
                'featured'      => 0,
                'view'          => 200,
                'sales_count'   => 50,
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now(),
            ],
        ]);
    }
}
