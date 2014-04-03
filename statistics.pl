use Sys::Statistics::Linux; 

#esto es la hostia¡¡ como leches no te lo enseñan en la uni o en el grado????

#sub disk{
#use Sys::Statistics::Linux::DiskUsage;
#my $xls =  Sys::Statistics::Linux::DiskUsage->new;
#my $stat1= $xls->get; 
#if ($stat1){
#print " $stat1->{total}\n";}
#else{ print "la cagamos";}
#}



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

#NOTA DEL AUTOR: estos son parametros aleatorios dentro de cada uno de los paquetes si se desea alguno en especial porfavor no dude en consultar. 
 my$stat = $lxs->get(); 

sub top5 {
my@top5= $stat->pstop(	ttime =>5); 
print "los 5 procesos que mas consumen: @top5 \n";
}
sub cpu {
my $cpu = $stat->cpustats->{cpu};
	print " user of the system: $cpu->{user} \n";
	print "porcentage de uso  total de la cpu:  $cpu->{total} %\n"; 

}
	sub loadavg {
#	my $loadavg = $stat->loadavg->{cpu}; 
#	print "loadavg $loadavg \n";
foreach my $key ($stat->loadavg){
 	
print $key, "", $stat->loadavg($key), "\n";

}
sub cpu1 {
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
  
 


}
 
sub memory {
	my $memory = $stat->memstats;
	print "memoria total usada : $memory->{memused} KB \n";
	print "memoria RAM usada : $memory->{swapused} KB \n";
}
 #sub disk {
#use Sys::Statistics::Linux::DiskStats;
#my $lxs = Sys::Statistics::Linux::DiskStats->new;
#$lxs->init();
#sleep 1; 
#my $stat = $lxs->get;
#my $disk = $stat->{rdbyt};
#print "numero de bytes leidos por el disco fisico por segundo:$disk\n"; 
#}
sub usodedisco { 
use Filesys::Df;
my $ref = df ("/dev/sda1");
if (defined($ref)) {
print "total blocks in /dev/sda1 :$ref->{blocks} Kb\n ";
print "total free space in /dev/sda1 : $ref->{bfree} Kb\n";
print "total used space in /dev/sda1: $ref->{used} Kb\n";
}






 	#print "espacio libre del mismo: $usodedisco->{free} \n";


}
sub sysinfo{
	my $sysinfo = $stat->sysinfo;
	print "the hostname : $sysinfo->{hostname} \n";
	print "THE UPTIME, THE FUCKING UPTIME : $sysinfo->{uptime} \n";
	print "tamaño total de swap: $sysinfo->{swaptotal} \n";
	print "tamaño total de memoria: $sysinfo->{memtotal}\n";
	print "nombre de cpu's fisicas: $sysinfo->{pcpucount}\n";
	print "nombre de nucleos: $sysinfo->{tcpucount}\n";
	print "nombre del kernel: $sysinfo->{kernel}\n";
	print "interfaces del "

}
sub procesos {
	my $procesos = $stat->procstats;
	print "procesos funcionando: $procesos->{running}\n";
	print "procesos creandose: $procesos->{new} por segundo\n";
	print " número de procesos en crom y anacron : $procesos->{runqueue}\n";
	print "numero de procesos bloqueados: $procesos->{blocked}\n";
	print "procesos que existen: $procesos->{count}\n";
}
#sub net {
#use Data::Dropper; 

#use Sys::Statistics::Linux::NetStats;
#my $lxs = Sys::Statistics::Linux::NetStats->new;
#$lxs->init;
#sleep 1;
#my $stat = $lxs->get_raw();
#Dropp: $stat;
#print "numero de bytes recibidos por segundo: $stat->{rxbyt}\n";
	

#}

sub files {
my $files = $stat->filestats;
print " maximo numero de inodos : $files->{infree}\n";
print "free directory cache size: $files->{unused}\n";
print "cuando se acaba la memoria .... : $files->{wantpages}\n";
#print "number of max inodes: $sock->{inmax}\n";
}

sub sock{
my $sock= $stat->sockstats;
print "numero de sockets usados: $sock->{used}\n";
print "numero de fragmentos de ip en uso: $sock->{ipfrag}\n";
print "number of raw sockets in use: $sock->{raw}\n";
print "number of udp sockets in use: $sock->{udp}\n";
print "number of tcp sockets in use. $sock->{tcp}\n";
}



&top5;
&cpu; 
&loadavg;
&memory; 
 
&sysinfo;
&procesos;
 
&files; 
&sock;
&cpu1;
&usodedisco;

