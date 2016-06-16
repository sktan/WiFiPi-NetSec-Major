#!/usr/bin/env python
 
import sys, time, socket, subprocess
from daemon import Daemon
 
class MyDaemon(Daemon):
        def run(self):
		TCP_IP = '0.0.0.0'
		TCP_PORT = 27015
		BUFFER_SIZE = 128
		s = socket.socket(socket.AF_INET, socket.SOCK_STREAM)
		s.bind((TCP_IP, TCP_PORT))
		s.listen(1)

		while True:
		        conn, addr = s.accept()
		        while True:
		                data = conn.recv(BUFFER_SIZE)
		                if not data: break
		                print data
		                conn.send(data)
		                p = subprocess.Popen(["iptables", "-A", "FORWARD", "-s", data, "-i", "wlan0", "-j", "ACCEPT"], stdout=subprocess.PIPE)
		                output , err = p.communicate()
			conn.close()
 
if __name__ == "__main__":
        daemon = MyDaemon('/tmp/daemon-example.pid')
        if len(sys.argv) == 2:
                if 'start' == sys.argv[1]:
                        daemon.start()
                elif 'stop' == sys.argv[1]:
                        daemon.stop()
                elif 'restart' == sys.argv[1]:
                        daemon.restart()
                else:
                        print "Unknown command"
                        sys.exit(2)
                sys.exit(0)
        else:
                print "usage: %s start|stop|restart" % sys.argv[0]
                sys.exit(2)
