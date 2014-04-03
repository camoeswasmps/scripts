sub cpu {
use Sys::Info;
use Sys::Info::Constants qw( :device_cpu );

my $info = Sys::Info->new;
my $cpu = $info->device( CPU => %options );
$k = $cpu->bitness; 
$m = $cpu->count; 
$s = $cpu->load || 0;  
$t = $cpu->speed || 'N/A';
$x = scalar($cpu->identify) || 'N/A';
#$l = $cpu->load(DCPU_LOAD_LAST_01); 


printf "the arquitecture is : $k\n";

printf "the number of cores are: $m\n";
printf "CPU: $s\n"; 
printf "CPU speed is $t MHz\n";
printf "$x\n";
     
}

&cpu;  
#printf "the cpu load is: $l\n";

#printf "$cpu \n";
#print "$info\n";
