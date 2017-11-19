### Setting up cowrie

###### Grabbing the dependencies
```
$sudo apt-get install git python-virtualenv libssl-dev libffi-dev build-essential libpython-dev python2.7-minimal authbind
```

###### Making a new user for cowrie only
```
$ sudo adduser --disabled-password cowrie
$ sudo su - cowrie
```

###### Grabbing necessary files
```
$ git clone http://github.com/micheloosterhof/cowrie
```

###### Setting up the virtual environment
```
$ cd cowrie
$ pwd
/home/cowrie/cowrie
$ virtualenv cowrie-env
$ source cowrie-env/bin/activate
(cowrie-env) $ pip install --upgrade pip
(cowrie-env) $ pip install --upgrade -r requirements.txt
```

###### Creating keys to avoid possible future problems
```
$ cd data
$ ssh-keygen -t dsa -b 1024 -f ssh_host_dsa_key
$ cd ..
```
###### Exporting path to avoid future problems
```
$ export PYTHONPATH=/home/cowrie/cowrie
```
###### Redirecting traffic coming to port 22 to port 2222
```
$ sudo iptables -t nat -A PREROUTING -p tcp --dport 22 -j REDIRECT --to-port 2222
```

Lastly, cowrie.cfg was modified to change the hostname to admintest. Otherwise the .cfg file is unchanged.
