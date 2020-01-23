import sys
fin  = open(sys.argv[1], 'r')
fout = open(sys.argv[2], 'w')

for line in fin:
	if line.count('PORT') > 0 and line.count('STATE') > 0 and line.count('SERVICE') > 0:
		break
for line in fin:
	if (len(line) > 1):
		fout.write(line)
	else:
		break

fin.close()
fout.close()
