# Examples

This directory contains useful examples built around the library's API.

---
### [`tree.c`](tree.c)
Contains the simplest C source code to print the OID tree in console, like `snmptranslate` does.

You don't need to worry about that file (i.e. compile it nor use.). It's provided for reference only to compare 
implementations. The `print_mib_tree()` used there, as you probably can see, doesn't allow for any information 
extraction and does what is says: prints an ASCII tree to console.  
That's actually the secret behind [very sparse code](https://salsa.debian.org/debian/net-snmp/-/blob/debian/5.8+dfsg-2/apps/snmptranslate.c)
of `snmptranslate` for what id does ;)

```
% ./native-tree 'SYNOLOGY-DISK-MIB::diskTable'
+--diskTable(1)
   |
   +--diskEntry(1)
      |  Index: diskIndex, diskStatus
      |
      +-- ---- Integer32 diskIndex(1)
      |        Range: 0..2147483647
      +-- -R-- String    diskID(2)
      +-- -R-- String    diskModel(3)
      +-- -R-- String    diskType(4)
      +-- -R-- Integer32 diskStatus(5)
      |        Range: 1..5
      +-- -R-- Integer32 diskTemperature(6)
```

**Compilation**
```
gcc -lnetsnmp -o native-tree tree.c`
```


**Usage**
```
chmod +x native-tree
./native-tree 'SNMPv2-MIB::system'
```

---
### [`tree.php`](tree.php)
The file contains a simple (yet vistually pleasing ;)) PHP source code to print the OID tree in console.

![php example](../.github/tree-example.png)

**Usage**
```
chmod +x ./tree.php
./tree.php 'SNMPv2-MIB::system'
```
