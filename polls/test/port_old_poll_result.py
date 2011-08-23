#/usr/bin/env python

poll_id = 63
option_id_one = 116
option_id_two = 117
option_id_three = 118


total_votes = 810

option_one_count = 605
option_two_count = 205
option_three_count = 0


for i in range( 0, option_one_count ):
	print "INSERT INTO votes(poll_id,option_id )VALUES(%d,%d);" % ( poll_id, option_id_one )

for i in range( 0, option_two_count ):
	print "INSERT INTO votes(poll_id,option_id )VALUES(%d,%d);" % ( poll_id, option_id_two )

