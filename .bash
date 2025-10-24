# ~/.bashrc - General Bash Profile
echo '--- marketing cloud bash profile loaded ---'

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
