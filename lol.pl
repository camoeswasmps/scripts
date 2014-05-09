 use Mojolicious::Lite;
 use Sys::Statistics::Linux;
 use Data::Dumper;
 use JSON;
 
 
    my %options = (
             sysinfo =>1,
              cpustats => 1,
              procstats =>1,
              memstats =>1 ,
              pgswstats =>1,
             netstats => 1,
              sockstats =>1, 
             diskstats =>1,  
              diskusage =>1,
              loadavg =>1,
              filestats =>1,
              processes =>1,
    
    );
    my $lxs = Sys::Statistics::Linux->new(\%options);
    sleep 1;
  
 my$stat = $lxs->get();


get '/' => sub {
my $self =shift;
my $cpu = $stat->cpustats->{cpu};
my $sock = $stat->sockstats;
use Sys::Info;
use Sys::Info::Constants qw( :device_cpu );
 
 my $info = Sys::Info->new;
 my $cpu2 = $info->device( CPU => %options );
 my $k = $cpu2->bitness;
 my $m = $cpu2->count;
 my $s = $cpu2->load || 0;
 my $t = $cpu2->speed || 'N/A';
 my $x = scalar($cpu2->identify) || 'N/A';
 #$l = $cpu->load(DCPU_LOAD_LAST_01); 

 my $memory = $stat->memstats;
          

 

 
 
 





  
  
 #45 
# 46 }
#sub top5 {
 my@top5= $stat->pstop(  ttime =>5);
# 32 print "los 5 procesos que mas consumen: @top5 \n";
# 33 }

#sub usodedisco {
 use Filesys::Df;
# my $ref = df ("/dev/sda1");
 my $ref = df("/dev/sda1", 1);#aqui es donde seleccionamos el dato de paquete, byte, megabyte, giga etc. 


#sub sysinfo{
         my $sysinfo = $stat->sysinfo;
#sub procesos {

          my $procesos = $stat->procstats;
#126         print "procesos funcionando: $procesos->{running}\n";
#127         print "procesos creandose: $procesos->{new} por segundo\n";
#128         print "número de procesos en crom y anacron : $procesos->{runqueue}\n";
#         print "numero de procesos bloqueados: $procesos->{blocked}\n";
#130         print "procesos que existen: $procesos->{count}\n";
#131 }

#ub files {
my $files = $stat->filestats;
#148 print "maximo numero de inodos : $files->{infree}\n";
#149 print "free directory cache size: $files->{unused}\n";
#150 print "cuando se acaba la memoria .... : $files->{wantpages}\n";
#151 #prin#it "number of max inodes: $sock->{inmax}\n";
#152 }







$self->render(json => { 'number of max inodes'=> $sock->{inmax}, 'cuando se acaba la memoria ' => $files->{wantpages}, 'free directory cache size'=> $files->{unused}, 'maximo numero de inodos' => $files->{infree},'procesos que existen'=> $procesos->{count},'numero de procesos bloqueados' => $procesos->{blocked}, 'número de procesos en crom y anacron '=> $procesos->{runqueue},  ' procesos creandose'=> $procesos->{new},   ' procesos funcionando:'=> $procesos->{running}, ' nombre del kernel:'=> $sysinfo->{kernel}, ' nombre de nucleos:'=> $sysinfo->{tcpucount}, 'nombre de cpus fisicas:'=> $sysinfo->{pcpucount}, 'tamaño total de memoria:'=> $sysinfo->{memtotal}, 'tamaño total de swap:'=> $sysinfo->{swaptotal},  'uptime :'=> $sysinfo->{uptime},  'the hostname '=> $sysinfo->{hostname} ,' total used space in /dev/sda1'=> $ref->{used}, 'total free space in /dev/sda1:'=> $ref->{bfree}, 'total blocks in /dev/sda1'=>$ref->{blocks}, 'top5'=>@top5,  'cpu total' => $cpu->{total}, 'system' => $cpu->{system}, 'number used sockets'=>$sock->{used}, 'ipfrag' => $sock->{ipfrag}, 'number raw sockets' => $sock->{raw}, 'number udp sockets' => $sock->{udp}, 'number tcp sockets' => $sock->{tcp} , 'load' => $s, 'bits' => $k, 'speed' => $t, 'dont know wtf is this' =>$x, 'total used memory' => $memory->{memused}, 'total free memory' => $memory->{realfreeper}, 'total RAM used' => $memory->{swapused}}); 



};

app->start; 
