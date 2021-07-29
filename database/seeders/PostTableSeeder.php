<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Carbon;

class PostTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */

    public function randomeDate(){
        return  Carbon::now()->subDays(rand(0, 30))->format('Y-m-d h:i:s');
    }

    public function run()
    {
        // $faker = Faker::create('id_ID');
        // $user = User::find(1);
        // for ($i=0; $i < 4 ; $i++) {
        //     $user->posts()->create([
        //         'caption' => $faker->text($maxNBChars = 1000),
        //         'image'   => $faker->image($dir= 'public/storage/posts', $width = 640, $height = 480, 'cats', false),
        //     ]);
        // }

        // $user = User::find(2);
        // for ($i=0; $i < 4 ; $i++) {
        //     $user->posts()->create([
        //         'caption' => $faker->text($maxNBChars = 1000),
        //         'image'   => $faker->image($dir= 'public/storage/posts', $width = 640, $height = 480, 'cats', false),
        //     ]);
        // }

        // $user = User::find(3);
        // for ($i=0; $i < 4 ; $i++) {
        //     $user->posts()->create([
        //         'caption' => $faker->text($maxNBChars = 1000),
        //         'image'   => $faker->image($dir= 'public/storage/posts', $width = 640, $height = 480, 'cats', false),
        //     ]);
        // }
        // $user = User::find(4);
        // for ($i=0; $i < 4 ; $i++) {
        //     $user->posts()->create([
        //         'caption' => $faker->text($maxNBChars = 1000),
        //         'image'   => $faker->image($dir= 'public/storage/posts', $width = 640, $height = 480, 'cats', false),
        //     ]);
        // }
        // $user = User::find(5);
        // for ($i=0; $i < 4 ; $i++) {
        //     $user->posts()->create([
        //         'caption' => $faker->text($maxNBChars = 1000),
        //         'image'   => $faker->image($dir= 'public/storage/posts', $width = 640, $height = 480, 'cats', false),
        //     ]);
        // }



        $data1 = "Hormati alam, maka alam akan menghormatimu. selamat hari laut sedunia!";
        $data2 = "Mari kita jaga bumi kita";
        $data3 = "Bro headset.";


        $user = User::find(1);
        $captionData = [$data1, $data2, $data3];
        $imageData = ["hari_laut_sedunia", "hari_bumi", "headset"];
        for ($i = 0; $i < count($captionData); $i++) {
            $user->posts()->create([
                'caption' => $captionData[$i],
                'image'   => $imageData[$i] . ".png",
                'created_at' => $this->randomeDate()
            ]);
        }

        $data1 = "Selamat bergabung, calon fullstack web developer masa depan!

Siap memulai perjalanan 5 bulan kedepan, melawan zona nyaman, demi masa depan yang lebih baik dan bermanfaat, bersama Skydu Academy";
$data2 = "Mari kita asah otak di hari minggu!";
$data3 = "Udah lama ya gak bikin kuis hihi
Nah Aku min balik lagi ngasih kuis buat kalian nih.";
$data4 = "Hai sob!
Siapa di sini yang weekend masih kerja?";
$data5 = "Hobi adalah kegiatan atau aktivitas yang dapat menjadi kesenangan tersendiri.
Tapi sebenarnya hobi itu tidak hanya terbatas pada hal-hal untuk menghilangkan penat aja loh! Ada juga hobi yang bermanfaat dan bisa bikin kita makin produktif.
Hm.. kira-kira apa aja ya?
Langsung aja yuk cek postingan di atas!
Kalo kamu, udah puya hobi yang mana nih ?";
        $user = User::find(2);
        $captionData = [$data1,$data2, $data3, $data4, $data5];
        $imageData = ["new-batch", "console-skydu", "kuis-js", "reminder-skydu", "hobi"];
            for ($i=0; $i < count($captionData) ; $i++) {
            $user->posts()->create([
                'caption' => $captionData[$i],
                'image'   => $imageData[$i].".png",
                'created_at' => $this->randomeDate()
            ]);
        }

$data1 = "<p>Indonesia mengirimkan lima atlet cabang angkat besi untuk bertanding dalam lima kategori berbeda di ajang Olimpiade 2020.
<p></p>
Salah satu wakil Indonesia untuk cabang angkat berat di Olimpiade Tokyo 2020, adalah Windy Aisah yang turun di kelas 49 kg putri.
</p><p>
Windy Aisah akhirnya sukses meraih medali perunggu berkat total angkatan 194 kg pada babak final yang berlangsung pada Sabtu (24/7/2021) siang WIB.
</p><p>
Medali perunggu tersebut sekaligus menjadi yang pertama bagi kontingen Indonesia di ajang Olimpiade Tokyo 2020</p>";
$data2 = "Bak tanah yang dijanjikan, Mars sering dianggap sebagai masa depan manusia Bumi. Di planet merah itulah, manusia berharap dapat meneruskan kehidupan dan beregenerasi saat Bumi sudah tidak mampu menopang segala hajat hidup makhluk di atasnya.";
$data3 = "<p>Ada cara membuat mac and cheese rumahan yang mudah. Kamu bisa mengikuti resep mac and cheese praktis tanpa menggunakan oven atau microwave.</p>
<p>
Mac and cheese yang satu ini terasa spesial karena menambahkan irisan sosis Hungaria atau bisa juga diganti dengan sosis biasa dan kangkung. Tertarik untuk mencobanya? Coba resep mac and cheese berikut.
</p>
Infografik: Andika Bayu";

        $user = User::find(3);
        $captionData = [$data1,$data2, $data3];
        $imageData = ["kompas-1", "kompas-2", "kompas-3"];
            for ($i=0; $i < count($captionData) ; $i++) {
            $user->posts()->create([
                'caption' => $captionData[$i],
                'image'   => $imageData[$i].".png",
                'created_at' => $this->randomeDate()
            ]);
        }

        $data1 = "Tidak peduli apa yg orang lain katakan, hal baik tidak akan berubah menjadi buruk hanya karena perkataan mereka✨🔥 #lfl💛";
        $data2 = "Sibuk itu bohong, semua tergantung prioritas🌝";
        $data3 = "Oke kamu jos😎";
        $user = User::find(4);
        $captionData = [$data1,$data2, $data3];
            for ($i=0; $i < count($captionData) ; $i++) {
            $a = 1 + $i;
            $user->posts()->create([
                'caption' => $captionData[$i],
                'image'   => "tanti-".$a.".png",
                'created_at' => $this->randomeDate()
            ]);
        }
        $data1 = "Lebih baik disini rumah kita sendiri";
        $data2 = "T - rex baby 🦖";
        $user = User::find(5);
        $captionData = [$data1,$data2];
            for ($i=0; $i < count($captionData) ; $i++) {
            $a = 1 + $i;
            $user->posts()->create([
                'caption' => $captionData[$i],
                'image'   => "yudha-" . $a . ".png",
                'created_at' => $this->randomeDate()
            ]);
        }
        $data1 = "Fotonya sendirian terus, foto sama kamunya kapan 😂😍";
        $data2 = "<p>
        Kalaupun dia tidak tahu kita menyukainya.
Kalaupun dia tidak tahu kita merindukannya.
Kalaupun dia tidak tahu kita menghabiskan waktu memikirkannya.
        </p>
<p>
Maka itu tetap cinta. Tidak berkurang se-senti perasaan tersebut.
Bersabar dan diam lebih baik. Jika memang jodoh akan terbuka sendiri jalan terbaiknya. Jika tidak, akan diganti dengan orang yang lebih baik.</p>";
        $user = User::find(6);
        $captionData = [$data1,$data2];
            for ($i=0; $i < count($captionData) ; $i++) {
                $a = 1+ $i;
            $user->posts()->create([
                'caption' => $captionData[$i],
                'image'   => "ba-" . $a . ".png",
                'created_at' => $this->randomeDate()
            ]);
        }


    }
}
