# .bashrc

# User specific aliases and functions

# Source global definitions
if [ -f /etc/bashrc ]; then
	. /etc/bashrc
fi
export PATH=$PATH:~/git/bin:~/mysql/bin/
export MODULEBUILDRC="/home/work/perl5/.modulebuildrc"
export PERL_MM_OPT="INSTALL_BASE=/home/work/perl5"
export PERL5LIB="/home/work/perl5/lib/perl5:/home/work/perl5/lib/perl5/x86_64-linux-thread-multi"
export PATH="/home/work/perl5/bin:$PATH"

alias p='pwd'
alias cp='cp -i'
alias mv='mv -i'
alias rm='rm -i'
alias ls='ls --color'
alias ll='ls -lrt'
alias c='clear'
pskill()
{
  local pid

   pid=$(ps -ax | grep $1 | grep -v grep | gawk '{ print $1 }')
   echo -n "killing $1 (process $pid)..."
   kill -9 $pid
   echo "slaughtered."
}

lamp=/home/work/gaoshuai/LAMP
alias lm='ls -al' |less
alias h='history'




