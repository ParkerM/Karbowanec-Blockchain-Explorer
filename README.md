# Pegglecoin-Blockchain-Explorer
Block explorer for Pegglecoin CryptoNote based cryptocurrency. (forked from [Karbovanets/Karbowanec-Blockchain-Explorer](https://github.com/Karbovanets/Karbowanec-Blockchain-Explorer))

#### Installation

1) It takes data from daemon pegglecoind. It should be accessible from the Internet. Run pegglecoind with open port as follows:
```bash
./pegglecoind --rpc-bind-ip=0.0.0.0 --rpc-bind-port=20421
```
2) Just upload to your website and change 'api' variable in config.js to point to your daemon.
