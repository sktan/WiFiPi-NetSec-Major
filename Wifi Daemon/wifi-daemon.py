#!/usr/bin/env python
 
import sys, time, socket, subprocess, base64
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
                                if data == "list":
		                        p = subprocess.Popen(["iwlist", "wlan1", "scan"], stdout=subprocess.PIPE)
		                        output , err = p.communicate()

                                        wifi_networks = re.findall('ESSID:"([^"]*)"', output)
                                        conn.send("|".join(wifi_networks))
		                elif data.startswith("firewall"):
		                        conn.send(data)

                                        data = data[9:]
		                        p = subprocess.Popen(["iptables", "-A", "FORWARD", "-s", data, "-i", "wlan0", "-j", "ACCEPT"], stdout=subprocess.PIPE)
		                        output , err = p.communicate()
                                elif data.startswith("wifi"):
                                        wifi_params = data.split()
                                        wifi_network = wifi_params[0].decode('base64')
                                        wifi_password = wifi_params[0].decode('base64')

                                        p = subprocess.Popen(["wpa_passphrase", wifi_network, wifi_password], stdout=subprocess.PIPE)
                                        output , err = p.communicate()

                                        orig_config = "ctrl_interface=DIR=/var/run/wpa_supplicant GROUP=netdev\n"
                                        orig_config += "update_config=1\n"
                                        orig_config += "country=GB\n\n"

                                        wpa_config = orig_config + output

                                        f = open("/etc/wpa_supplicant/wpa_supplicant.conf", "w");
                                        f.write(wpa_config);
                                        f.close();

                                        conn.send(output)
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
