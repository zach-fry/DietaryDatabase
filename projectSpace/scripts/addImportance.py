d = {}

f = open('../survey.csv')
headers = f.readline().strip().split(',')
#print headers
#print len(headers)
for line in f:
    if line.find('"') >= 0:
        pass
    else:
        if len(line.strip().split(',')) == len(headers):
            responses = line.strip().split(',')
            #print headers
            #print responses
            for i in range(len(responses)):
                response = responses[i]
                header = headers[i]

                #print '%s\t%s'%(header, response)

                if header not in d: d[header] = 0
                if response.find('unimportant') >= 0:
                    if response.find('Somewhat') >= 0:
                        d[header] -= 1
                    else:
                        d[header] -= 2
                elif response.find('care') >= 0:
                    pass
                else:
                    if response.find('Somewhat') >= 0:
                        d[header] += 1
                    elif response.find('Extremely') >= 0:
                        d[header] += 2
                    else:
                        pass

f.close()

for k,v in sorted(d.iteritems(), key=lambda x: x[1]):
    if v > 0:
        print '%s\t%s'%(k,v)


