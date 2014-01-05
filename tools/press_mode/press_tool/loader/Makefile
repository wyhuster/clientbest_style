
CC=gcc 
CFLAGS = -c -std=c99 -g
LD=gcc
OBJS=main.o config.o cpu.o mem.o meminfo.o
all:loader

mem.o:mem.c mem.h main.h config.h
cpu.o:cpu.c main.h config.h
meminfo.o:meminfo.c mem.h main.h config.h


loader: $(OBJS) mem.h main.h config.h
	$(LD) $(OBJS) -o loader


clean:
	rm -rf *.o loader


