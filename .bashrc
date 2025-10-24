# ~/.bashrc - General Bash Profile
echo '~/.bashrc loaded'

# basics
export PS1='$ '

alias cls="clear"

#mcdev
function mc() {

    if [ $1 = "types" ]; then
        mcdev selectTypes --debug
        return 1
    fi

    if [ $1 = "get" ]; then
        mcdev retrieve
        return 1
    fi
} 

#ollama
