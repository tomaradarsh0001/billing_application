<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;


class OccupantDetailsSeeder extends Seeder
{
    public function run()
    {
        $occupants = [
            ['mobile' => '9810115598', 'email' => 'bibek.debroy@gov.in', 'occupation_date' => '22.07.2017', 'h_id' => 1],
            ['mobile' => null, 'email' => 'YET TO SHIFT', 'occupation_date' => null, 'h_id' => 2],
            ['mobile' => null, 'email' => null, 'occupation_date' => '22.06.2024', 'h_id' => 3],
            ['mobile' => null, 'email' => null, 'occupation_date' => '10.09.2024', 'h_id' => 4],
            ['mobile' => '9999311285', 'email' => null, 'occupation_date' => '23.11.2022', 'h_id' => 5],
            ['mobile' => '9810637577', 'email' => 'amitabh.kant@nic.in', 'occupation_date' => '05.06.2017', 'h_id' => 6],
            ['mobile' => '8527179660', 'email' => null, 'occupation_date' => '08.08.2023', 'h_id' => 7],
            ['mobile' => '9825561046', 'email' => 'jmpanchal46@gmail.com', 'occupation_date' => '09.09.2013', 'h_id' => 8],
            ['mobile' => '9810557231', 'email' => 'rajeevkumar@nic.in', 'occupation_date' => '22.12.2021', 'h_id' => 9],
            ['mobile' => null, 'email' => null, 'occupation_date' => '27.10.2023', 'h_id' => 10],
            ['mobile' => '8130375035', 'email' => 'ewdhc123@gmail.com', 'occupation_date' => '27.06.2022', 'h_id' => 11],
            ['mobile' => null, 'email' => null, 'occupation_date' => null, 'h_id' => 12],
            ['mobile' => '8130375035', 'email' => 'shivamgarg.ncw@nic.in', 'occupation_date' => '21.12.2024', 'h_id' => 13],
            ['mobile' => '8700300084', 'email' => null, 'occupation_date' => '28.05.2024', 'h_id' => 14],
            ['mobile' => '9810381133', 'email' => null, 'occupation_date' => '16.08.2021', 'h_id' => 15],
            ['mobile' => null, 'email' => 'ewdhc123@gmail.com', 'occupation_date' => '01.08.2022', 'h_id' => 16],
            ['mobile' => '9873117000', 'email' => 'ratanpw@yahoo.com', 'occupation_date' => '14.11.2012', 'h_id' => 17],
            ['mobile' => '9845999747', 'email' => 'office-psa@nic.in', 'occupation_date' => '21.07.2022', 'h_id' => 18],
            ['mobile' => '9978406155', 'email' => 'bidyutswain@gmail.com', 'occupation_date' => '06.09.2021', 'h_id' => 19],
            ['mobile' => '9868119996', 'email' => 'sujata.chaturvedi@nic.in', 'occupation_date' => '15.07.2022', 'h_id' => 20],
            ['mobile' => '9810804515', 'email' => null, 'occupation_date' => '21.04.2022', 'h_id' => 21],
            ['mobile' => '9811502924', 'email' => 'mamidala.ugc@gov.in', 'occupation_date' => '28.11.2022', 'h_id' => 22],
            ['mobile' => '9868871124', 'email' => null, 'occupation_date' => '30.11.2020', 'h_id' => 23],
            ['mobile' => '#REF!', 'email' => 'nidhi.khare@nic.in', 'occupation_date' => '12.10.2018', 'h_id' => 24],
            ['mobile' => '9448141944', 'email' => 'a.shrivastava@nic.in', 'occupation_date' => '23.01.2023', 'h_id' => 25],
            ['mobile' => '9868861954', 'email' => 'kumarrajeshsinghias@gmail.com', 'occupation_date' => '15.02.2023', 'h_id' => 26],
            ['mobile' => '9871293199', 'email' => null, 'occupation_date' => '17.08.2022', 'h_id' => 27],
            ['mobile' => '#REF!', 'email' => 'shamikaravi2021@gmail.com', 'occupation_date' => '27.06.2023', 'h_id' => 28],
            ['mobile' => '7070894444', 'email' => 'sanjay_kumar@me.com', 'occupation_date' => '17.11.2022', 'h_id' => 29],
            ['mobile' => '9818577560', 'email' => null, 'occupation_date' => '16.01.2024', 'h_id' => 30],
            ['mobile' => '9868162277', 'email' => 'secybm@mha.gov.in', 'occupation_date' => null, 'h_id' => 31],
            ['mobile' => '9425127125', 'email' => 'manoj.govil@nic.in, secy.mca@nic.in', 'occupation_date' => '21.07.2023', 'h_id' => 32],
            ['mobile' => '9810907437', 'email' => 's.barthwal@nic.in', 'occupation_date' => '27.05.2022', 'h_id' => 33],
            ['mobile' => '9815836450', 'email' => null, 'occupation_date' => '14.06.2024', 'h_id' => 34],
            ['mobile' => '8872090003', 'email' => 'vinim@nic.in', 'occupation_date' => '04.03.2022', 'h_id' => 35],
            ['mobile' => '9968818110', 'email' => 'd.chaturvedi@nic.in', 'occupation_date' => '25.10.2024', 'h_id' => 36],
            ['mobile' => '9417178929', 'email' => 'sukritil@yahoo.com', 'occupation_date' => '24.04.2024', 'h_id' => 37],
            ['mobile' => '9711067661', 'email' => 'tarun.bajaj@nic.in', 'occupation_date' => '13.10.2017', 'h_id' => 38],
            ['mobile' => '8754429111', 'email' => 'secretary@meity.gov.in', 'occupation_date' => '23.11.2023', 'h_id' => 39],
            ['mobile' => null, 'email' => 'ewdhc123@gmail.com', 'occupation_date' => '04.02.2023', 'h_id' => 40],
            ['mobile' => '9810998063', 'email' => 'secy.security@nic.in', 'occupation_date' => '25.01.2024', 'h_id' => 41],
            ['mobile' => null, 'email' => 'ewdhc123@gmail.com', 'occupation_date' => '15.04.2024', 'h_id' => 42],
            ['mobile' => null, 'email' => 'ewdhc123@gmail.com', 'occupation_date' => '01.04.2023', 'h_id' => 43],
            ['mobile' => '9811241445', 'email' => 'vl_krao@yahoo.com', 'occupation_date' => null, 'h_id' => 44],
            ['mobile' => '9810063440', 'email' => null, 'occupation_date' => '16.10.2023', 'h_id' => 45],
            ['mobile' => null, 'email' => 'ewdhc123@gmail.com', 'occupation_date' => '23.12.2022', 'h_id' => 46],
            ['mobile' => null, 'email' => null, 'occupation_date' => '18.07.2023', 'h_id' => 47],
            ['mobile' => '9958981627', 'email' => 'punhanir@nic.in', 'occupation_date' => '16.05.2023', 'h_id' => 48],
            ['mobile' => null, 'email' => null, 'occupation_date' => null, 'h_id' => 49],
            ['mobile' => '9425009065', 'email' => 'ualka@ias.nic.in', 'occupation_date' => '15.02.2023', 'h_id' => 50],
            ['mobile' => '9953355599', 'email' => 'dghs@nic.in', 'occupation_date' => '11.02.2021', 'h_id' => 51],
            ['mobile' => '9811559987', 'email' => 'secy.dbt@nic,in', 'occupation_date' => '01.08.2022', 'h_id' => 52],
            ['mobile' => '9868833666', 'email' => 's.garg@gov.in', 'occupation_date' => '10.08.2023', 'h_id' => 53],
            ['mobile' => '9319776507', 'email' => 'laltanmaya@gmail.com', 'occupation_date' => '15.11.2024', 'h_id' => 54],
            ['mobile' => '9560276348', 'email' => 'sanjeev.kumar70@nic.in', 'occupation_date' => null, 'h_id' => 55],
            ['mobile' => '9425176715', 'email' => 'secy-power@nic.in', 'occupation_date' => null, 'h_id' => 56],
            ['mobile' => '9013850426', 'email' => 'dir-enforcement@nic.in', 'occupation_date' => '06.03.2019', 'h_id' => 57],
            ['mobile' => '9899313027', 'email' => 'anilk.jain@nic.in', 'occupation_date' => '09.07.2020', 'h_id' => 58],
            ['mobile' => '9919800299', 'email' => 'ceo@fssai.gov.in', 'occupation_date' => '06.11.2020', 'h_id' => 59],
            ['mobile' => '9415527999', 'email' => null, 'occupation_date' => '01.06.2023', 'h_id' => 60],
            ['mobile' => '9810190110', 'email' => 'vivek.joshi@nic.in', 'occupation_date' => '31.08.2022', 'h_id' => 61],
            ['mobile' => '9650422244', 'email' => null, 'occupation_date' => '26.03.2025', 'h_id' => 62],
            ['mobile' => '9873173140', 'email' => 'shivsarin@gmail.com', 'occupation_date' => '29.10.2012', 'h_id' => 63],
            ['mobile' => '9753973001', 'email' => 'a_tirkey16@rediffmail.com', 'occupation_date' => '07.06.2021', 'h_id' => 64],
            ['mobile' => '9461616987', 'email' => 'drji@ayu.in', 'occupation_date' => '30.08.2018', 'h_id' => 65],
            ['mobile' => '9999490670', 'email' => null, 'occupation_date' => '27.09.2024', 'h_id' => 66],
            ['mobile' => '9444977595', 'email' => null, 'occupation_date' => '01.01.2022', 'h_id' => 67],
            ['mobile' => '9013852382', 'email' => 'rahulnavin@gmail.com', 'occupation_date' => '30.11.2024', 'h_id' => 68],
            ['mobile' => '9650080778', 'email' => 'pavan.kapoor@gmail.com', 'occupation_date' => '05.06.2024', 'h_id' => 69],
            ['mobile' => '9560750889', 'email' => null, 'occupation_date' => '08.10.2024', 'h_id' => 70],
            ['mobile' => '9650384141', 'email' => null, 'occupation_date' => '02.09.2022', 'h_id' => 71],
            ['mobile' => '9978408081', 'email' => 'srinivas.kat@nic.in', 'occupation_date' => '13.03.2024', 'h_id' => 72],
            ['mobile' => '#REF!', 'email' => 'chanchal.kumar@nic.in', 'occupation_date' => '02.02.2025', 'h_id' => 73],
            ['mobile' => '9999636588', 'email' => 'secy.wcd@nic.in', 'occupation_date' => '09.03.2022', 'h_id' => 74],
            ['mobile' => '9811911110', 'email' => 'ss.dubey@nic.in', 'occupation_date' => '22.09.2023', 'h_id' => 75],
            ['mobile' => null, 'email' => 'ewdhc123@gmail.com', 'occupation_date' => '19.06.2023', 'h_id' => 76],
            ['mobile' => '9971697232', 'email' => 'krishna.vatsa@ndma.gov.in', 'occupation_date' => '23.09.2020', 'h_id' => 77],
            ['mobile' => '9444954422', 'email' => 'sanjayarora90@yahoo.com', 'occupation_date' => '13.04.2022', 'h_id' => 78],
            ['mobile' => '9449030120', 'email' => null, 'occupation_date' => '11.01.2019', 'h_id' => 79],
            ['mobile' => '9717300833', 'email' => 'nivshukla@gmail.com', 'occupation_date' => '15.02.2024', 'h_id' => 80],
            ['mobile' => null, 'email' => 'ewdhc123@gmail.com', 'occupation_date' => '28.11.2022', 'h_id' => 81],
            ['mobile' => '9958966388', 'email' => 'tuhin.pandey@gmail.com', 'occupation_date' => '10.10.2020', 'h_id' => 82],
            ['mobile' => '9471006271', 'email' => 'secy.moc@nic.in', 'occupation_date' => '06.04.2023', 'h_id' => 83],
            ['mobile' => '9910078911', 'email' => 'secybm@nic.in', 'occupation_date' => '27.09.2023', 'h_id' => 84],
            ['mobile' => '9502103177', 'email' => 'dawras@ias.nic.in', 'occupation_date' => '22.05.2024', 'h_id' => 85],
            ['mobile' => '9672491419', 'email' => 'sanjay.malhotra.ias@gmail.com', 'occupation_date' => '01.09.2022', 'h_id' => 86],
            ['mobile' => '9448290830', 'email' => 'revas-mof@gov.in', 'occupation_date' => '07.04.2022', 'h_id' => 87],
            ['mobile' => '9971489555', 'email' => null, 'occupation_date' => '25.11.2024', 'h_id' => 88],
            ['mobile' => null, 'email' => null, 'occupation_date' => '01.04.2023', 'h_id' => 89],
            ['mobile' => '9599971448', 'email' => 'santhree@gmail.com', 'occupation_date' => '08.04.2022', 'h_id' => 90],
            ['mobile' => '9999685852', 'email' => 'sanjmur@gmail.com', 'occupation_date' => '07.10.2022', 'h_id' => 91],
            ['mobile' => '7217838730', 'email' => 'shaileshksingh@gmail.com', 'occupation_date' => '16.06.2023', 'h_id' => 92],
            ['mobile' => '9840122675', 'email' => 'vibhunayar@gmail.com', 'occupation_date' => '26.02.2024', 'h_id' => 93],
            ['mobile' => '9810021515', 'email' => 'leenanandan@hotmail.com', 'occupation_date' => '01.02.2021', 'h_id' => 94],
            ['mobile' => '9999038828', 'email' => 'poundrik@yahoo.com', 'occupation_date' => '14.10.2024', 'h_id' => 95],
            ['mobile' => '8587899999', 'email' => 'secy-food@nic.in', 'occupation_date' => '28.11.2020', 'h_id' => 96],
            ['mobile' => '9999835353', 'email' => 'rajeshaggarwal.ias@gmail.com', 'occupation_date' => '11.05.2023', 'h_id' => 97],
            ['mobile' => '9810093288', 'email' => 'mukhmeet@gmail.com', 'occupation_date' => '20.01.2023', 'h_id' => 98],
            ['mobile' => null, 'email' => null, 'occupation_date' => '19.12.2019', 'h_id' => 99],
            ['mobile' => '9358815482', 'email' => 'fertsec@nic.in', 'occupation_date' => '10.04.2024', 'h_id' => 100],
            ['mobile' => '9818621439', 'email' => 'jaideepindia1@gmail.com', 'occupation_date' => '27.05.2024', 'h_id' => 101],
            ['mobile' => '9818406633', 'email' => 'sheelvardhan@gmail.com', 'occupation_date' => '22.12.2021', 'h_id' => 102],
            ['mobile' => '9958811444', 'email' => 'mittal1967@gmail.com', 'occupation_date' => '14.10.2024', 'h_id' => 103],
            ['mobile' => null, 'email' => null, 'occupation_date' => null, 'h_id' => 104],
            ['mobile' => null, 'email' => null, 'occupation_date' => '18.04.2024', 'h_id' => 105],
            ['mobile' => '9445541144', 'email' => 'tkrias2020@gmail.com', 'occupation_date' => '14.12.2023', 'h_id' => 106],
            ['mobile' => '9810185012', 'email' => 'vanita_manoj@yahoo.com', 'occupation_date' => '22.04.2024', 'h_id' => 107],
            ['mobile' => '9811455220', 'email' => 'govindmohan1@gmail.com', 'occupation_date' => '13.04.2022', 'h_id' => 108],
            ['mobile' => '9439027711', 'email' => 'secy-food@nic.in', 'occupation_date' => '01.02.2023', 'h_id' => 109],
            ['mobile' => '9560557777', 'email' => null, 'occupation_date' => '15.04.2024', 'h_id' => 110],
            ['mobile' => '9479003078', 'email' => 'csoffice@nic.in', 'occupation_date' => '04.09.2021', 'h_id' => 111],
            ['mobile' => '8527452939', 'email' => 'mang@gov.in', 'occupation_date' => '25.09.2024', 'h_id' => 112],
            ['mobile' => '9448290802', 'email' => 'secy-dea@nic.in', 'occupation_date' => '16.09.2021', 'h_id' => 113],
            ['mobile' => '9441229296', 'email' => 'secretary@moes.gov.in', 'occupation_date' => '14.03.2022', 'h_id' => 114],
            ['mobile' => '9560695035', 'email' => 'k.moseschalai@nic.in', 'occupation_date' => '22.04.2024', 'h_id' => 115],
            ['mobile' => '9811387876', 'email' => 'uttarakhand.sadan@gmail.com', 'occupation_date' => '01.11.2022', 'h_id' => 116],
        ];
    
        $names = [
            'Late Sh. Bibek Debroy', 
            'SH. CHANDRA SHEKHAR', 
            'SH. GYANESH KUMAR', 
            'SH. SUKHBIR SINGH SANDHU', 
            'SH. MANOJ JOSHI', 
            'SH. AMITABH KANT', 
            null, 
            'HON\'BLE MR. JUSTICE J.M. PANCHAL', 
            'SH. RAJIV KUMAR', 
            null, 
            'HON\'BLE MR. JUSTICE SANJEEV NARULA', 
            null, 
            'SMT. VIJAYA KISHORE RAHATKAR', 
            'SH. ARVIND PANAGARIYA',
            'SH. ARAMANE GIRIDHAR', 
            'MS. JUSTICE SWARANA KANTA SHARMA', 
            'SH. RATAN P. WATAL', 
            'SH. AJAY KUMAR SOOD', 
            'SH. BIDYUT BEHARI SWAIN', 
            'MS. SUJATA CHATURVEDI', 
            'MS. ANSHULI ARYA', 
            'SH. PROF. M. JAGADESH KUMAR', 
            'SH. PRADIP KUMAR TRIPATHI', 
            'SMT. NIDHI KHARE', 
            'SH. ARVIND SHRIVASTAVA', 
            'SH. RAJESH KUMAR SINGH', 
            'SH. SANJEEV SANYAL', 
            'SMT. SHAMIKA RAVI', 
            'SH. SANJAY KUMAR', 
            'SH. UMANG NARULA',
            'SH. RAJENDRA KUMAR',
            'DR. MANOJ GOVIL',
            'SH. SUNIL BARTHWAL',
            'SH ANIL MALIK',
            'MS. VINI MAHAJAN',
            'SH. DEVESH CHATURVEDI',
            'SH. ABHILAKSH LIKHI',
            'SMT. BINDU BAJAJ',
            'SH. S KRISHNAN',
            'MS. JUSTICE MINI PUSHKARNA',
            'SH. SWAGAT DAS',
            'HON\'BLE JUSTICE AMIT MAHAJAN',
            'HON\'BLE JUSTICE SACHIN DATTA',
            'SH. V. L. KANTHA RAO',
            'HON\'BLE JUSTICE ANISH DAYAL',
            'MS. JUSTICE TARA VITASTA GANJU',
            'HON\'BLE JUSTICE PURUSHAINDRA KUMAR KAURAV',
            'SH. RAJIT PUNHANI',
            null,
            'MS. ALKA UPADHYAYA',
            'DR. SUNIL KUMAR',
            'DR. RAJESH S GOKHALE',
            'SH. SAURABH GARG',
            'SH. TANMAYA LAL',
            'SH. SANJEEV KUMAR',
            'SH. PANKAJ AGARWAL',
            'SH. SANJAY KUMAR MISHRA',
            'SH. ANIL KUMAR JAIN',
            'SH. ARUN SINGHAL',
            'SH. KAMRAN RIZVI',
            'SH. VIVEK JOSHI',
            'SH. A. K. BHALLA',
            'DR. S. K. SARIN',
            'SH. AJAY TIRKEY',
            'SH. VAIDYA RAJESH KOTECHA',
            'SMT. VANDITA KAUL',
            'MS. ANITA PRAVEEN',
            'SH. RAHUL NAVIN',
            'SH. PAVAN KAPOOR',
            'SMT. V VIDYAVATHI',
            'SMT. ANNIE GEORGE MATHEW',
            'SH. SRINIVAS RAMASWAMY KATIKITHALA',
            'SH. CHANCHAL KUMAR',
            'SH. INDEVAR PANDEY',
            'SH. SHYAM SUNDER DUBEY',
            'HON\' BLE MR. JUSTICE SAURABH BANERJEE',
            'SH. KRISHNA VATSA',
            'SH. SANJAY ARORA',
            'SH. PRADEEP SINGH KHAROLA',
            'SMT. NIVEDITA SHUKLA VERMA',
            'JUSTICE VIKAS MAHAJAN',
            'SH. TUHIN KANTA PANDEY',
            'SH. AMRIT LAL MEENA',
            'SH. ATAL DULLOO',
            'SMT. SUMITA DAWRA',
            'SH. SANJAY MALHOTRA',
            'SH. ANIL KUMAR JHA',
            'SMT. VANDANA GURNANI',
            'VICE PRESIDENT\'S SECRETARIAT',
            'SH. SANJAY VERMA',
            'SH. K SANJAY MURTHY',
            'SH. SHAILESH KUMAR SINGH',
            'SH. VIBHU NAYAR',
            'SMT. LEENA NANDAN',
            'SH. SANDEEP POUNDRIK',
            'SH. SUDHANSHU PANDEY',
            'SH. RAJESH AGGARWAL',
            'SH. MUKHMEET SINGH BHATIA',
            'JUSTICE RAJENDRA MENON',
            'SH. RAJAT KUMAR MISHRA',
            'SH. JAIDEEP MAZUMDAR',
            'SH. SHEEL VARDHAN SINGH',
            'SH. NEERAJ MITTAL',
            'PUNYA S. SRIVASTAVA',
            'SH. RAJ KUMAR GOYAL',
            'SH. T K RAMACHANDRAN',
            'SH. MANOJ YADAVA',
            'SH. GOVIND MOHAN',
            'SH. SANJEEV CHOPRA',
            'SMT. NINA SINGH',
            'SH. B V R SUBRAHMANYAM',
            'SH. V. VUMLUNMANG',
            'SH. AJAY SETH',
            'SH. M. RAVICHANDRAN',
            'SH. K. MOSES CHALAI',
            'SH. PUSHKAR SINGH DHAMI, CM'
        ];
    
        foreach ($occupants as $index => $occupant) {
            $name = $names[$index] ?? null;
            $nameParts = $name ? explode(' ', $name, 2) : [];
            $first_name = $nameParts[0] ?? null;
            $last_name = $nameParts[1] ?? null;
            
            $unique_id = 'OD' . str_pad($index + 1, 5, '0', STR_PAD_LEFT);
            $mobile = in_array($occupant['mobile'], ['#REF!', 'YET TO SHIFT', 'VACANT', null]) ? null : $occupant['mobile'];
            
            $email = $occupant['email'];
            if (in_array($email, ['YET TO SHIFT', 'VACANT', null, ''])) {
                $email = null;
            } elseif (DB::table('occupant_details')->where('email', $email)->where('h_id', '!=', $occupant['h_id'])->exists()) {
                $email = str_replace('@', '+' . $occupant['h_id'] . '@', $email);
            }
                $occupation_date = null;
            if (!in_array($occupant['occupation_date'], ['YET TO SHIFT', 'VACANT', null, ''])) {
                try {
                    $occupation_date = Carbon::createFromFormat('d.m.Y', $occupant['occupation_date'])->format('Y-m-d');
                } catch (\Exception $e) {
                    $occupation_date = null;
                }
            }
    
            DB::table('occupant_details')->updateOrInsert(
                ['h_id' => $occupant['h_id']],
                [
                    'unique_id' => $unique_id,
                    'first_name' => $first_name,
                    'last_name' => $last_name,
                    'mobile' => $mobile,
                    'email' => $email,
                    'phone_code_id' => 99,
                    'occupation_date' => $occupation_date,
                    'updated_at' => now(),
                    'created_at' => now(),
                ]
            );
        }
    }
}
