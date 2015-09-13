# build helloworld executable when user executes "make"

raspberry: pmaxd
pmaxd: pmaxd.o
	$(CC) $(LDFLAGS) pmaxd.o -o pmaxd -lconfig -lpthread

pmaxd: pmaxd.o
	$(CC) $(LDFLAGS) pmaxd.o -o pmaxd -lconfig -lpthread
pmaxd.o: pmaxd.c
	$(CC) $(CFLAGS) -c -g -lpthread pmaxd.c 

raspberry_clean:
	rm *.o pmaxd
