#!/usr/bin/perl
#
# wwwPartigene_align.cgi - a script to align the sequences from a cluster
# 
#

use CGI qw(:standard);
#use Bio::Seq;
use File::stat;

#$cluster= "AHC00027";#(param('CLUSTER'));
$cluster= (param('CLUSTER'));
#$contig= "1";#(param('CONTIG'));
$contig= (param('CONTIG'));
#$num_seqs_cluster = "2";#(param('NUM_SEQS'));
$num_seqs_cluster = (param('NUM_SEQS'));
$cluster =~ /(\w\w\w)/;
$chosenorganism = $1;
#the following line is edited by the setup script
$organism_info = "/var/www/enchy/EAC/organism.info";

print header(-type=>'text/html');
start_html("A Page");
#  	print "<body bgcolor=\"#FFFFFF\"><FONT FACE=\"Arial\" SIZE=\"+2\" >";
#	print "cluster is $cluster\nchosen org is $chosenorganism<BR>";

if ($num_seqs_cluster ==1) {
	print header(-type=>'text/html');
  	start_html("A Page");
  	print "<body bgcolor=\"#FFFFFF\"><FONT FACE=\"Arial\" SIZE=\"+2\" >";
	print "Cluster $cluster is a singleton, so no phrap assembly files (.ace) have been produced for this cluster<BR>";
	
	exit();
}
open (fh, "<$organism_info");
while ($line= <fh>) {
	if ($line =~ $chosenorganism) {
		$chosen_org_info = $line;
		last;
	}
}
#print "chosen org info is $chosen_org_info\n";

$clusterorganism = "$cluster $chosen_org_info";
#$pattern= "/^(\w\w\w\d\d\d\d\d)\s(\w\w\w)\s(\w+_\w+) (\S+) (\S+) (\S+) (\S+) (\S+) (\S+) (\S+) (\S+) (\S+) (\S+)/i";
$clusterorganism =~ /^(\w\w\w\d\d\d\d\d) (\w\w\w) (\w+_\w+) (\S+) (\S+) (\S+) (\S+) (\S+) (\S+) (\S+) (\S+) (\S+) (\S+)/;

$cluster=$1;
$cid=$2;
$sid=$3;
$species=$sid;
$psqldb=$4;
$psqluser=$5;
$location=$6;	#i.e. blast dir
$ace_files = $7;
$blast1=$8;
$blasttype1=$9;
$blast2=$10;
$blasttype2=$11;
$blast3=$12;
$blasttype3=$13;

$species=~ s/\_/ /;
#print header(-type=>'text/html');
#  start_html("A Page");
  #print "<body bgcolor=\"#FFFFFF\">";
  #print "<center><font size=+2>Alignment of sequences in $cluster Contig $contig";
  #print "</font><br><br><font color=\"0000FF\">Blue</font>=low quality ; ";
  #print "<font color=\"00AA00\">Green</font>=medium quality ; ";
  #print "<font color=\"FF0000\">Red</font>=high quality<br>";
  #print "cluster = $cluster\n$cid\n$sid\n$species\n$blast1\n$blasttype1\n$blast2\n$blasttype2\n$blast3\n$blasttype3\n$location\n$psqldb\n$psqluser\n$ace_files\n";
  



# Find and retreive sequences
##modify_next_line
#print "looking for $ace_files/$cluster.ace\n";
if(-e("$ace_files/$cluster.ace")) {

#print "retrieving $cluster information";
##modify_next_line
  open(fh, "<$ace_files/$cluster.ace");

  $flag=0;
  $index=0;
  $index1=0;

  while($line=<fh>)  {
    if($line=~/^CO/) { $flag=0; }
    if($line=~/Contig(\d+)/ && $1==$contig) {  $contigseq=''; $flag=1; next; }
    if($line=~/^BQ/ && $flag==1) { $flag=2; next; }
    if($line=~/^.+/ && $flag==1) { chomp $line; $contigseq.=$line; next; }
    if($line=~/^AF\s(.+)\s(\w)\s(.+)/ && $flag==2)
      { $est[$index]=$1; $start[$index]=$3-1; $index++; next; }
    if($line=~/^RD/ && $flag==2) 
      { $estseq[$index1]=''; $flag=3;  next; }
    if($line=~/^.+/ && $flag==2) { chomp $line; $qualseq.=$line; next; }
    if($line=~/^QA\s(\d+)\s(\d+)\s(\d+)\s(\d+)/ && $flag==3)   { 
      $s="here";
      $q_start[$index1]=$1;
      $q_end[$index1]=$2;
      $a_start[$index1]=$3;
      $a_end[$index1]=$4;
      $flag=2;
      $index1++;
      next;   
    }
    if($line=~/^.+/ && $flag==3) {  chomp $line; $estseq[$index1].=$line; next; }
  }

  close(fh);

  $length=length($contigseq);

  for($i=0;$i<$index;$i++) {
    @seq=split("",$estseq[$i]);
    for($l=0;$l<$length;$l++)  {
      if($l >= $start[$i] && $l < $a_end[$i]+$start[$i] )
        { $aliseq[$i][$l]=$seq[$l-$start[$i]]; }
      else
        { $aliseq[$i][$l]='.'; }
    }
  }


  @cseg=split("",$contigseq);
  @qseq=split(" ",$qualseq);

  #print header(-type=>'text/html');
  #start_html("A Page");
  print "<body bgcolor=\"#FFFFFF\">";
  print "<center><font size=+2>Alignment of sequences in $cluster Contig $contig";
  print "</font><br><br><font color=\"0000FF\">Blue</font>=low quality ; ";
  print "<font color=\"00AA00\">Green</font>=medium quality ; ";
  print "<font color=\"FF0000\">Red</font>=high quality<br>";


  print "<table>";
  for($h=0;$h<$length/60;$h++) {
    $st=$h*60;
    print "<tr><td width=100><br></td></tr>";
    print "<tr><td width=100><br></td><td><font face=monospace>";
    for($idx=1;$idx<61;$idx++)  {
      if($idx % 10 == 0)   { $x=$st+$idx; print "$x"; }
      elsif($idx < 10)   { print "."; }
      elsif($idx % 10 >= length($x))  { print "."; }
    }
    print "</tr><tr><td><font face=fixed>Contig $contig</td><td><font face=monospace>";
    for($idx=$h*60;$idx<60+($h*60);$idx++)  {
      $col="0000FF";
      if($qseq[$idx]>20) { $col="00AA00"; }
      if($qseq[$idx]>40) { $col="FF0000"; }
  
      print "<font color=\"$col\">$cseg[$idx]</font>";
    }
    print "</td></tr>\n";
    for($i=0;$i<$index;$i++) {
      print "<tr><td><font face=fixed>$est[$i]</td><td><font face=monospace>";
      for($idx=$h*60;$idx<60+($h*60);$idx++)   { 
        print "$aliseq[$i][$idx]"; 
      }
      print "</td></tr>\n";
    }
  }
  print "</table><br><br>";
  end_html(); 
}

else {
  print header(-type=>'text/html');
  start_html("A Page");
  print "<body bgcolor=\"#FFFFFF\">";
  print "Sorry no assembly (ace) file associated with this contig";
  end_html(); 
}

##########################################################





