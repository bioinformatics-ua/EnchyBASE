#!/usr/bin/perl -w

#######################################################################################
# ViroBLAST
# blast.pl
# Copyright � University of Washington. All rights reserved.
# Written by Wenjie Deng in the Department of Microbiology at University of Washington.
#######################################################################################

use strict;

my $basicParam = $ARGV[0];
my $advanceParam = $ARGV[1];
my ($jobid, $searchType, $blastagainst, $program, $blastPath) = split /\t/, $basicParam;

if ($blastPath =~ /\/\s*$/) {
	$blastPath =~ s/\/\s*$//;
}
my $dataPath = "./data";
open LOG, ">$dataPath/$jobid.log";

my $format = 0;
# viroblast default setting for max target sequences is 50
my $num_descriptions = my $num_alignments = 50;

print LOG "Job Id: ", $jobid, "\n";
print LOG "Search type: $searchType\n";
print LOG "Blast against: ", $blastagainst, "\n";
print LOG "Program: ", $program, "\n";
print LOG "Blast path: ", $blastPath, "\n";

my $command = "$blastPath/$program";
if ($program eq 'blastn' || $program eq 'blastp') {
	$command .= " -task $program";
}
$command .= " -db \"$blastagainst\" -query $dataPath/$jobid.blastinput.txt -out $dataPath/$jobid.out";
if ($searchType eq "basic") {
	$command .= " -html";
}else {
	my ($expect, $wordSize, $targetSeqs, $mmScore, $matrix, $gapCost, $filter, $softMask, $lowerCaseMask, $ungapAlign, $outfmt, $geneticCode, $dbGeneticCode, $otherParam) = split /!#%/, $advanceParam;
	$num_descriptions = $num_alignments = $targetSeqs;
	$format = $outfmt;
	unless ($format) {
		$command .= " -html";
	}
	$command .= " -evalue $expect -word_size $wordSize -outfmt $format";
	print LOG "Expect: $expect\n";
	print LOG "Word size: $wordSize\n";
	print LOG "Max target sequences: $targetSeqs\n";	
	if ($mmScore) {
		my ($reward, $penalty) = split /,/, $mmScore;
		$command .= " -reward $reward -penalty $penalty";	
		print LOG "Nucleotide match reward: $reward\n";
		print LOG "Nucleotide mismatch penalty: $penalty\n";
	}
	if ($matrix) {
		$command .= " -matrix $matrix";
		print LOG "Matrix: $matrix\n";
	}
	if ($gapCost && $gapCost =~ /Existence: (\d+), Extension: (\d+)/) {	# tblastx no gap costs options
		my $gapOpen = $1;
		my $gapExtend = $2;
		$command .= " -gapopen $gapOpen -gapextend $gapExtend";
		print LOG "Gap open cost: $gapOpen\n";
		print LOG "Gap extend cost: $gapExtend\n";
	}
	print LOG "Filter low complexity regions: $filter\n";
	print LOG "Mask for lookup table only: $softMask\n";
	print LOG "Mask for lower case letters: $lowerCaseMask\n";
	print LOG "Perform ungapped alignment: $ungapAlign\n";
	print LOG "BLAST output format: $format\n";
	if ($filter eq 'F') {
		if ($program eq 'blastn') {	# for blastn, default filter is "-dust yes"
			$command .= " -dust no";
		}else {	# else except blastp, default filter is "-seg yes";
			unless ($program eq 'blastp') {
				$command .= " -seg no";
			}			
		}
	}else {
		if ($program eq 'blastp') {	# for blastp, default filter is "-seg no"
			$command .= " -seg yes";
		}
	}
	if ($softMask eq 'F') {
		if ($program eq 'blastn') {	# the default value of soft masking for blastn is true
			$command .= " -soft_masking false";
		}
	}else {
		unless ($program eq 'blastn') {	# the default value of soft masking other than blastn is false
			$command .= " -soft_masking true";
		}
	}
	if ($lowerCaseMask eq 'L') {	# the default value of lower case masking for all programs is false
		$command .= " -lcase_masking";
	}
	if ($ungapAlign eq 'T') {	# default is gapped alignment
		$command .= " -ungapped";
	}
	if ($geneticCode) {
		$command .= " -query_gencode $geneticCode";
		print LOG "Query genetic code: $geneticCode\n";
	}
	if ($dbGeneticCode) {
		$command .= " -db_gencode $dbGeneticCode";
		print LOG "Database genetic code: $dbGeneticCode\n";
	}
	if ($otherParam) {
		$command .= " $otherParam";
		print LOG "Other parameters: $otherParam\n";
	}
}

$command .= " -num_descriptions $num_descriptions -num_alignments $num_alignments 2>$dataPath/$jobid.err";
print LOG "Command: $command\n";

if($blastagainst =~ /blastagainst\.txt/) {
	my $rv = 0;
	if ($program eq "blastp" || $program eq "blastx") {
		$rv = system("$blastPath/makeblastdb -in $dataPath/$jobid.blastagainst.txt -logfile $dataPath/$jobid.makeblastdb.log 2>$dataPath/$jobid.err");
	}else {
		$rv = system("$blastPath/makeblastdb -in $dataPath/$jobid.blastagainst.txt -logfile $dataPath/$jobid.makeblastdb.log -dbtype nucl 2>$dataPath/$jobid.err");
	}
	unless ($rv == 0) {
		print LOG "makeblastdb failed: $rv\n";
		open ERR, ">>$dataPath/$jobid.err" or die "couldn't open $jobid.err\n";
		print ERR "makeblastdb failed\n";
		close ERR;
		close LOG;
		exit;
	}
}
my $rv = system ($command);
unless ($rv == 0) {
	print LOG "Program failed: $rv\n";
	close LOG;
	exit;
}

my $infile = "$dataPath/$jobid.out";
open(IN, $infile) || die "Cannot open in file\n";
if ($format) {
	open (OUT, ">$dataPath/$jobid.blast") or die "Couldn't open $jobid.blast: $!\n";
	while (my $line = <IN>) {
		chomp $line;
		print OUT $line,"\n";
	}
	close OUT;
}else {	
	my $size = (-s $infile);
	my $num_query = 0;
	my @query_array = ();
	while(my $line = <IN>) {
		if($line =~ /<b>Query=<\/b>/) {
			$num_query++;			
		}
		if($line =~ /<b>Query=<\/b>\s*$/) {
			my $query_name = "Query".$num_query;
			push(@query_array, $query_name);
		}elsif($line =~ /<b>Query=<\/b>\s+(.*?)[,;\s+]/) {
			my $query_name = $1;		
			push(@query_array, $query_name);	
		}
	}
	close IN;
	my $num_page = 1;
	my $size_per_page = 0;
	if($size > 6000000) {
		$num_page = int($size/5000000 + 1);
		$size_per_page = int($size/$num_page/100000)/10;
	}
	
	open(IN, $infile) || die "Cannot open in file\n";
	open(OUT1, ">$dataPath/$jobid.blast1.html") || die "Cannot open file $jobid.blast1.html: $!\n";
	open(OUT2, ">$dataPath/$jobid.out.par") || die "Cannot open file $jobid.out.par: $!\n";
	open(OUT3, ">$dataPath/$jobid.par") || die "Cannot open file $jobid.par: $!\n";
	open(OUT4, ">$dataPath/$jobid.blastcount.txt") || die "Cannot open file $jobid.blastcount.txt: $!\n";
	
	my $query_flag = 0;
	my $print_flag = 0;
	my $cutoff_count = 0;
	my $acc_query = 0;
	my $queryLen = 0;
	my $page = 1;
	my $open_flag = 1;
	my $tmp_file = "$dataPath/$jobid.blast_tmp.html";
	my $index_file = "$dataPath/$jobid.blast_index.txt";
	my $firstPRE = 1;
	my $start_query = my $end_query = 1;
	my $link = "";
	my $top_query = "";
	my ($query_name, $match_name, $name_anchor, $gi, $score, $e_value);
	while(my $line = <IN>) {
		if($line =~ /<b>Query=<\/b>/) {
			$acc_query++;
			if($open_flag == 1) {
				$start_query = $acc_query;
			}
			$query_flag = 1;
		}
		
		if ($query_flag && $line =~ /\Length=(\d+)/i) {
			$queryLen = $1;
			$query_flag = 0;
		}
		
		if($line =~ /^(.*)\s+\<a href\s*=\s*(#\S+)>\s*\S+<\/a>/) {
			$match_name = $1;
			$name_anchor = $2;
			$gi = 0;
			if ($match_name =~ /gi\|(\d+)/ || $match_name =~ /\w+\|(\w+\.\d+)/) {
				$gi = $1;
				$match_name =~ /^\s*(.*?)[,;\s+]/;
				$match_name = $1;
				$match_name =~ s/\|/!#%/g;
				$line =~ s/\|/!#%/g;
				$line =~ s/$match_name/<a href=http:\/\/www.ncbi.nlm.nih.gov\/nuccore\/$gi?report=genbank target=_blank>$match_name<\/a>/;				
				$match_name =~ s/!#%/\|/g;
				$line =~ s/!#%/\|/g;
				$link = "<a href=http://www.ncbi.nlm.nih.gov/nuccore/$gi?report=genbank target=_blank>$match_name</a>";
			}elsif($match_name =~ /^\s*(.*?)[,;\s+]/) {
				$match_name = $1;
			}
			$line =~ s/$name_anchor/#$query_name$match_name/;
		}elsif($line =~ /^(.*?)<a (name\s*=\s*\S+)><\/a>\s*(.*?)$/) {
			$name_anchor = $2;
			$match_name = $3;
			if ($1 =~ /<script src=\"blastResult\.js\"><\/script>/) {
				$line =~ s/<script src=\"blastResult\.js\"><\/script>//;
			}
			$gi = 0;
			if ($match_name =~ /gi\|(\d+)/ || $match_name =~ /\w+\|(\w+\.\d+)/) {	# blastn
				$gi = $1;
				if ($match_name =~ /^(.*?)[,;\s+]/ || $match_name =~ /^(\S+)/) {
					$match_name = $1;
				}
				$match_name =~ s/\|/!#%/g;
				$line =~ s/\|/!#%/g;
				$line =~ s/$match_name/$query_name on <a href=http:\/\/www.ncbi.nlm.nih.gov\/nuccore\/$gi?report=genbank target=_blank>$match_name<\/a>/;	
				$match_name =~ s/!#%/\|/g;
				$line =~ s/!#%/\|/g;
				$link = "<a href=http://www.ncbi.nlm.nih.gov/nuccore/$gi?report=genbank target=_blank>$match_name</a>";
			}elsif($match_name =~ /^(.*?)[,;\s+]/ || $match_name =~ /^(\S+)/) {
				$match_name = $1;
				$line =~ s/$match_name/$query_name on $match_name/;
				$link = $match_name;
			}
			$line =~ s/$name_anchor/name = $query_name$match_name/;			
			$print_flag = 1;
		}
		
		if($line =~ /<b>Query=<\/b>\s*$/) {
			$query_name = "Query".$acc_query;
			$line = "<a name = $query_name></a>".$line;
		}elsif($line =~ /<b>Query=<\/b>\s+(.*?)[,;\s+]/) {
			$query_name = $1;
			$line = "<a name = $query_name></a>".$line;
		}
		
		if($num_page > 1) {		
			if($open_flag == 1) {
				open(OUT, ">$tmp_file") || die "Cannot open out file: $tmp_file\n";
				print OUT $top_query;
				$open_flag = 0;
			}
			
			if($line =~ /<b>Query=<\/b>/ || $line =~ /<\/HTML>/i) {
				my $size_tmp_file = (-s $tmp_file)/1000000;
				if ($line =~ /<\/HTML>/i) {
					$end_query = $acc_query;
					print OUT $line;
					$open_flag = 1;
				}elsif($size_tmp_file >= $size_per_page) {					
					$end_query = $acc_query - 1;
					$open_flag = 1;
				}	
				
				if ($open_flag == 1) {	
					open(INDEX, ">$index_file") || die("Cannot open index file: $index_file\n");
					print INDEX "<HTML>\n";
					print INDEX "<TITLE>BLAST Search Results</TITLE>\n";
					print INDEX "<BODY BGCOLOR=\"#FFFFFF\" LINK=\"#0000FF\" VLINK=\"#660099\" ALINK=\"#660099\">\n";
					print INDEX "<PRE>\n";
					
					if($end_query == $num_query) {
						my $prev_page = $page - 1;
						print OUT "[<a href=$jobid.blast1.html>First</a>][<a href=$jobid.blast$prev_page.html>Previous</a>]  <b>Results of query sequence $start_query through $end_query</b>\n\n";
						print INDEX "[<a href=$jobid.blast1.html>First</a>][<a href=$jobid.blast$prev_page.html>Previous</a>]  <b>Results of query sequence $start_query through $end_query</b>\n\n";
					}else {
						if($page == 1) {
							print INDEX "<b>Results of query sequence $start_query through $end_query</b>  [<a href=$jobid.blast2.html>Next</a>][<a href=$jobid.blastlast.html>Last</a>]\n\n";
							print OUT "<b>Results of query sequence $start_query through $end_query</b>  [<a href=$jobid.blast2.html>Next</a>][<a href=$jobid.blastlast.html>Last</a>]\n\n";
						}else {
							my $prev_page = $page -1;
							my $next_page = $page + 1;
							print OUT "[<a href=$jobid.blast1.html>First</a>][<a href=$jobid.blast$prev_page.html>Previous</a>]  <b>Results of query sequence $start_query through $end_query</b>  [<a href=$jobid.blast$next_page.html>Next</a>][<a href=$jobid.blastlast.html>Last</a>]\n\n";
							print INDEX "[<a href=$jobid.blast1.html>First</a>][<a href=$jobid.blast$prev_page.html>Previous</a>]  <b>Results of query sequence $start_query through $end_query</b>  [<a href=$jobid.blast$next_page.html>Next</a>][<a href=$jobid.blastlast.html>Last</a>]\n\n";
						}
					}
					
					print INDEX "|";
					for(my $i = $start_query; $i <= $end_query; $i++) {
						my $query = shift(@query_array);
						print INDEX "<a href = #$query>$query</a>|";
					}
					print INDEX "\n<hr>\n\n";					
					print OUT "</body></html>";
					close INDEX;
					close OUT;
					my $blastfile = "$dataPath/$jobid.blast$page.html";
					system("cat $index_file $tmp_file > $blastfile");
					if($end_query == $num_query) {
						my $blastlastfile = "$dataPath/$jobid.blastlast.html";
						system("cat $index_file $tmp_file > $blastlastfile");
					}
					$page++;
					$start_query = $acc_query;
					$top_query = $line;
				}else {
					print OUT $line;
				}		
			}else {
				print OUT $line;
			}			
		}else {	#only one page
			if($firstPRE == 1 && $line =~ /^<PRE>/) {
				print OUT1 $line;
				print OUT1 "<b>BLAST Results</b>\n\n";
				if(scalar @query_array > 1) {
					print OUT1 "|";
					foreach (@query_array) {
						print OUT1 "<a href = #$_>$_</a>|";
					}
					print OUT1 "\n";
				}
				print OUT1 "<hr>\n\n";
				$firstPRE = 0;
			}else {
				print OUT1 $line;
			}
		}
	
		if($line =~ /Score =\s+(\S+)/) {
			$score = $1;
		}
		
		if($line =~ /Expect(.*)=\s+(\S+)/) {
			$e_value = $2;
		}
	
		if($line =~ /Identities \=\s+(\S+)\s+\((\d+)\%\)/) {
			my $identities = $1;
			my $percentage = $2;
	
			if($print_flag == 1) {
				print OUT2 $page."\t".$query_name."\t".$match_name."\t".$score."\t".$identities." (".$queryLen.")"."\t".$percentage."\t".$e_value."\t".$link."\n";
				$cutoff_count++;
	
				print OUT3 $page."\t".$query_name."\t".$match_name."\t".$score."\t".$identities." (".$queryLen.")"."\t".$percentage."\t".$e_value."\t".$link."\n";
				$print_flag = 0;
			}
			$link = "";
		}
	}
	print OUT4 $cutoff_count."\n";
	
	close OUT1;
	close OUT2;
	close OUT3;
	close OUT4;
}
close IN;
close LOG;

open(OUT6, ">$dataPath/$jobid.blaststring.txt") || die "Can't open out file\n";
print OUT6 "Finished blasting.\n";
close OUT6;
