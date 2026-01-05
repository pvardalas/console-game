<?php
        $user_name = "guest";
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Terminal</title>
    <link rel="stylesheet" href="css/style.css">
    <meta http-equiv="content-type"
        content="text/html; charset=UTF-8">
    <meta name="viewport" content=
        "width=device-width,minimum-scale=1,
        initial-scale=1">
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script src="https://unpkg.com/jquery.terminal/js/jquery.terminal.min.js"></script>
    <link rel="stylesheet" href="https://unpkg.com/jquery.terminal/css/jquery.terminal.min.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/crypto-js/4.0.0/core.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/crypto-js/3.1.9-1/md5.js"></script>
</head>

<body>
    <script>
        function toBinary(string) {
            const codeUnits = new Uint16Array(string.length);
            for (let i = 0; i < codeUnits.length; i++) {
                codeUnits[i] = string.charCodeAt(i);
            }
            return btoa(String.fromCharCode(...new Uint8Array(codeUnits.buffer)));
        }
        var terminal = $('body').terminal({
            help: function() {
                this.echo("I have written everything you need to know in a file called help.txt. To see it's content type 'cat help.txt'") 
            },
            cd: function(targetDir) {
                if (targetDir == null || targetDir == "~") {
                    this.currentDir = "~";
                    this.set_prompt(this.currentUsr + '@panos:' + this.currentDir + '$');
                }
                else {
                    if (this.currentDir == "~") {
                        if (targetDir == "/") {
                            this.currentDir = "/"
                            this.set_prompt(this.currentUsr+'@panos:'+this.currentDir+'$ ');
                        }
                        else if (targetDir == ".") {
                            return;
                        }
                        else if (targetDir == "important"){
                            this.currentDir = "~/important"
                            this.set_prompt(this.currentUsr+'@panos:'+this.currentDir+'$ ');
                        }
                        else if (targetDir == "Photos") {
                            this.currentDir = "~/Photos"
                            this.set_prompt(this.currentUsr+'@panos:'+this.currentDir+'$ ');
                        }
                        else if (targetDir == ".."){
                            this.currentDir = "/"
                            this.set_prompt(this.currentUsr+'@panos:'+this.currentDir+'$ ');
                        }
                        else {
                            this.echo("No such file or directory.")
                        }   
                    }
                    else if (this.currentDir == "/"){
                        if (targetDir == "/") {
                            return;
                        }
                        else if (targetDir == ".") {
                            return;
                        }
                        else if (targetDir == "home"){
                            this.currentDir = "~"
                            this.set_prompt(this.currentUsr + '@panos:' + this.currentDir + '$');
                        }
                        else if (targetDir == "root") {
                            if (this.currentUsr == 'guest') {
                                this.echo("Oops, looks like this directory can only be accessed by root. The password for root is stored in '/home/hash.txt' however it is hashed. Good luck...");
                            }
                            else if (this.currentUsr == 'root') {
                                this.currentDir = '/root';
                                this.set_prompt(this.currentUsr+'@panos:'+this.currentDir+'$ ');
                            }
                        }
                        else if (targetDir == "usr") {
                            this.echo("This is the directory for user data, there are more interesting directories to look at.");
                        }
                        else if (targetDir == "etc") {
                            this.echo("This is the directory for system configuration files, there are more interesting directories to look at.");
                        }
                        else if (targetDir == "bin") {
                            this.echo("This is the directory for binary or executable programs, there are more interesting directories to look at.");
                        }
                        else if (targetDir == "opt") {
                            this.echo("This is the directory for optional or third-party software, there are more interesting directories to look at.");
                        }   
                        else if (targetDir == "var") {
                            this.echo("This is the directory for log files, there are more interesting directories to look at.");
                        }                      
                        else if (targetDir == "tmp") {
                            this.echo("This is the directory for temporary files, there are more interesting directories to look at.");
                        }
                        else {
                            this.echo("No such file or directory.")
                        }                     
                    }
                    else if (this.currentDir == "~/important") {
                        if (targetDir == "/") {
                            this.currentDir = "/";
                            this.set_prompt(this.currentUsr+'@panos:'+this.currentDir+'$ ');
                        }
                        else if (targetDir == ".") {
                            return;
                        }
                        else if (targetDir == "..") {
                            this.currentDir = "~";
                            this.set_prompt(this.currentUsr + '@panos:' + this.currentDir + '$');                        
                        }
                        else {
                            this.echo("No such file or directory.")
                        }   
                    }
                    else if (this.currentDir == "~/Photos") {
                        if (targetDir == "/") {
                            this.currentDir = "/";
                            this.set_prompt(this.currentUsr+'@panos:'+this.currentDir+'$ ');
                        }
                        else if (targetDir == ".") {
                            return;
                        }
                        else if (targetDir == "..") {
                            this.currentDir = "~";
                            this.set_prompt(this.currentUsr + '@panos:' + this.currentDir + '$');                        
                        }
                        else {
                            this.echo("No such file or directory.")
                        }   
                    }   
                }
                             
            },
            ls: function() {
                if (this.currentDir == "~") {
                    this.echo("<div class='ls'><div class='file'>hash.txt</div><div class='file'>help.txt</div><div class='folder'>important</div><div class='folder'>Photos</div></div>")
                }
                else if (this.currentDir == "/"){
                    this.echo("<div class='ls'><div class='folder'>bin</div><div class='folder'>etc</div><div class='folder'>home</div><div class='folder'>opt</div><div class='special'>root</div><div class='folder'>tmp</div><div class='folder'>usr</div><div class='folder'>var</div></div>");
                }
                else if (this.currentDir == "~/important") {
                    this.echo("<div class='ls'><div class='executable'>message.sh</div><div class='file'>instructions.txt</div></div>");
                }
                else if (this.currentDir == "~/Photos") {
                    this.echo("<div class='ls'><div class='file'>img.png</div></div>")
                    this.echo("<div class='ls'><div class='special'>wordlist.xml</div></div>")
                }   
                else if (this.currentDir == "/root") {
                    this.echo("<div class='ls'><div class='file'>flag.txt</div></div>")
                } 
            },
            cat: function(file){
                if (this.currentDir == "~") {
                    if (file == "hash.txt") {
                        this.echo("34d7f98e9e8ef3d465cd9f04ef954cef");
                    }
                    else if (file == "help.txt") {
                        this.echo("------------------------------------------");
                        this.echo("Looks like you need some help");
                        this.echo("Let's get started")
                        this.echo("------------------------------------------");
                        this.echo("Refences used in linux:");
                        this.echo("directory = folder")
                        this.echo("root directory = the directory that contains all the other directories, subdirectories, and files on the system.")
                        this.echo("------------------------------------------");
                        this.echo("cd    | This command stands for 'Change Directory' and is used to go from a directory to another. Usage: cd [directory]. Example: cd Photos. Make sure the directory you are targeting is in the directory you are currently. You can go back with 'cd ..', in the home directory (~) with 'cd' or 'cd ~' or the root directory with 'cd /'");
                        this.echo("");
                        this.echo("ls    | This command stands for 'List' and is used to list all the files and directories in the current directory. Usage: ls");
                        this.echo("")
                        this.echo("cat   | This command stands for concatenate and is used to display the content of a file. Usage: cat [file]. Example cat help.txt. Make sure the file you are targeting is in the directory you are currenty.");
                        this.echo("clear | This command is used to wipe all the content shown in the screen. Usage: clear")
                        this.echo("fim   | This command stands for File Integrity Monitoring and is used to display an image. Usage: fim [file]. Make sure the file you are targeting is in the directory you are currenty.")
                        this.echo("su    | This command stands for Switch User and is used to switch from one user to an other. Usage: su [user].")
                        this.echo("bash  | This command is used to execute an executable file. Usage bash [file]. Make sure the file you are targeting is in the directory you are currenty.")
                        this.echo("------------------------------------------");
                        this.echo("Linux has a lot more commands, however these are the most fundamental.");
                        this.echo("Hope this helped you understand a bit of linux.");
                        this.echo("------------------------------------------");
                    }
                    else if (file =='Photos') {
                        this.echo("Photos: Is a directory")
                    }
                    else if (file =='important') {
                        this.echo("important: Is a directory")
                    }
                    else {
                        this.echo("No such file or directory");
                    }
                }
                else if (this.currentDir == "/"){
                    if (file =='usr') {
                        this.echo("usr: Is a directory")
                    }
                    else if (file =='var') {
                        this.echo("var: Is a directory")
                    }
                    else if (file =='etc') {
                        this.echo("etc: Is a directory")
                    }
                    else if (file =='home') {
                        this.echo("home: Is a directory")
                    }
                    else if (file =='root') {
                        this.echo("root: Is a directory")
                    }
                    else if (file =='opt') {
                        this.echo(">opt: Is a directory")
                    }
                    else if (file =='tmp') {
                        this.echo("tmp: Is a directory")
                    }
                    else if (file =='bin') {
                        this.echo("var: Is a directory")
                    }
                    else {
                        this.echo(">No such file or directory");
                    }                    
                }
                else if (this.currentDir == "~/important") {
                    if (file=="message.sh") {
                        this.echo("This file is an executable. Check help.txt in the ~ directory to find a command to use for this file'.");
                    }
                    else if (file == "instructions.txt"){
                        this.echo("------------------------------------------")
                        this.echo("I guess you are not up for a challenging task? Ok get some help and try to solve the problem...")
                        this.echo("------------------------------------------")
                        this.echo("There is a tool called 'bruteforcer' preinstalled in the system. You can use it by typing 'bruteforcer' in the terminal. It takes 2 arguments, the file containing a hash to crack and a wordlist with the possible passwords. There is a wordlist intalled in the system but I don't know where, you should look for it. Make sure the syntax is: bruteforcer [file] [wordlist].")
                        this.echo("If you manage to find the password for the root account switch to root.");
                        this.echo("Then just find the file with the flag in the folder for root.")
                        this.echo("Good Luck!");
                        this.echo("------------------------------------------")
                    }
                    else {
                        this.echo("No such file or directory");
                    }
                }
                else if (this.currentDir == "~/Photos") {
                    if (file == "img.png") {
                        this.echo("This is an image. Check help.txt in the ~ directory to find a command to use for this file.")
                    }
                    else if (file == "wordlist.xml") {
                        this.echo("You found a wordlist. Use it with a tool to get what you are looking for.")
                    }
                } 
                else if (this.currentDir == '/root') {
                    if (file == 'flag.txt') {
                        this.echo("ro0tfl4g{gO0dJ0b}");
                        this.echo("Submit the flag with submitFlag [flag] [Your Name].")
                    }
                }
            },
            bruteforcer: function(hashfile, wordlist) {
                if (this.currentDir == "~") {
                    if (hashfile == null || wordlist == null) {
                        this.echo("You have to add the hash file and a wordlist. Usage bruteforcer [hashfile] [wordlist].")
                    }
                    else {
                        if (hashfile !== "hash.txt") {
                            this.echo("Couldn't find the hash file given.")
                        }
                        if (wordlist !== "Photos/wordlist.xml") {
                            this.echo("Couldn't find the wordlist file given");
                        }
                        if (hashfile == "hash.txt" && wordlist == "Photos/wordlist.xml") {
                            this.set_prompt('').pause(true)
                            this.echo("------------------------------------------");
                            this.echo("Bruteforcer v1.5");
                            setTimeout(() => {
                                this.echo("Reading wordlist");
                                setTimeout(() => {
                                    this.echo("<div class='failedPass'>password</div>");
                                    setTimeout(() => {
                                        this.echo("<div class='failedPass'>password123</div>");
                                        setTimeout(() => {
                                            this.echo("<div class='failedPass'>passwd</div>");
                                            setTimeout(() => {
                                                this.echo("<div class='failedPass'>12345678</div>");
                                                setTimeout(() => {
                                                    this.echo("<div class='failedPass'>root</div>");
                                                    setTimeout(() => {
                                                        this.echo("<div class='failedPass'>toor</div>");
                                                        setTimeout(() => {
                                                            this.echo("<div class='failedPass'>admin</div>");
                                                            setTimeout(() => {
                                                                this.echo("<div class='failedPass'>SecurePassword</div>");
                                                                setTimeout(() => {
                                                                    this.echo("<div class='failedPass'>password_1</div>");
                                                                    setTimeout(() => {
                                                                        this.echo("<div class='failedPass'>qwerty</div>");
                                                                        setTimeout(() => {
                                                                            this.echo("<div class='failedPass'>1q2w3e</div>");
                                                                            setTimeout(() => {
                                                                                this.echo("<div class='SuccessPass'>SuperSecretRootPassword123!@#_</div>");
                                                                                this.echo("------------------------------------------");
                                                                                this.echo("Found password: SuperSecretRootPassword123!@#_");
                                                                                terminal.set_prompt(this.currentUsr + '@panos:' + this.currentDir + '$').resume();
                                                                            }, 500)
                                                                        }, 500)
                                                                    }, 500)
                                                                }, 500)
                                                            }, 500)
                                                        }, 500)
                                                    }, 500)
                                                }, 500)
                                            }, 500)
                                        }, 500)
                                    }, 500)
                                }, 1000)
                            }, 1000);                            
                        }
                    }

                }
                else if (this.currentDir == "/"){
                    if (hashfile == null || wordlist == null) {
                        this.echo("You have to add the hash file and a wordlist. Usage bruteforcer [hashfile] [wordlist].")
                    }
                    else {
                        if (hashfile !== "home/hash.txt" || hashfile !== "~/hash.txt") {
                            this.echo("Couldn't find the hash file given.")
                        }
                        if (wordlist !== "home/Photos/wordlist.xml" || wordlist !== "~/Photos/wordlist.xml") {
                            this.echo("Couldn't find the wordlist file given");
                        }
                        if (hashfile == "home/hash.txt" && wordlist == "home/Photos/wordlist.xml" || hashfile == "home/hash.txt" && wordlist == "home/Photos/wordlist.xml") {
                            this.set_prompt('').pause(true)
                            this.echo("------------------------------------------");
                            this.echo("Bruteforcer v1.5");
                            setTimeout(() => {
                                this.echo("Reading wordlist");
                                setTimeout(() => {
                                    this.echo("<div class='failedPass'>password</div>");
                                    setTimeout(() => {
                                        this.echo("<div class='failedPass'>password123</div>");
                                        setTimeout(() => {
                                            this.echo("<div class='failedPass'>passwd</div>");
                                            setTimeout(() => {
                                                this.echo("<div class='failedPass'>12345678</div>");
                                                setTimeout(() => {
                                                    this.echo("<div class='failedPass'>root</div>");
                                                    setTimeout(() => {
                                                        this.echo("<div class='failedPass'>toor</div>");
                                                        setTimeout(() => {
                                                            this.echo("<div class='failedPass'>admin</div>");
                                                            setTimeout(() => {
                                                                this.echo("<div class='failedPass'>SecurePassword</div>");
                                                                setTimeout(() => {
                                                                    this.echo("<div class='failedPass'>password_1</div>");
                                                                    setTimeout(() => {
                                                                        this.echo("<div class='failedPass'>qwerty</div>");
                                                                        setTimeout(() => {
                                                                            this.echo("<div class='failedPass'>1q2w3e</div>");
                                                                            setTimeout(() => {
                                                                                this.echo("<div class='SuccessPass'>SuperSecretRootPassword123!@#_</div>");
                                                                                this.echo("------------------------------------------");
                                                                                this.echo("Found password: SuperSecretRootPassword123!@#_");
                                                                                terminal.set_prompt(this.currentUsr + '@panos:' + this.currentDir + '$').resume();
                                                                            }, 500)
                                                                        }, 500)
                                                                    }, 500)
                                                                }, 500)
                                                            }, 500)
                                                        }, 500)
                                                    }, 500)
                                                }, 500)
                                            }, 500)
                                        }, 500)
                                    }, 500)
                                }, 1000)
                            }, 1000);                            
                        }
                    }
                }
                else if (this.currentDir == "~/important") {
                    if (hashfile == null || wordlist == null) {
                        this.echo("You have to add the hash file and a wordlist. Usage bruteforcer [hashfile] [wordlist].")
                    }
                    else {
                        if (hashfile !== "../hash.txt" || hashfile !== "~/hash.txt") {
                            this.echo("Couldn't find the hash file given.")
                        }
                        if (wordlist !== "../Photos/wordlist.xml" || wordlist !== "~/Photos/wordlist.xml") {
                            this.echo("Couldn't find the wordlist file given");
                        }
                        if (hashfile == "../hash.txt" && wordlist == "~/Photos/wordlist.xml") {
                            this.set_prompt('').pause(true)
                            this.echo("------------------------------------------");
                            this.echo("Bruteforcer v1.5");
                            setTimeout(() => {
                                this.echo("Reading wordlist");
                                setTimeout(() => {
                                    this.echo("<div class='failedPass'>password</div>");
                                    setTimeout(() => {
                                        this.echo("<div class='failedPass'>password123</div>");
                                        setTimeout(() => {
                                            this.echo("<div class='failedPass'>passwd</div>");
                                            setTimeout(() => {
                                                this.echo("<div class='failedPass'>12345678</div>");
                                                setTimeout(() => {
                                                    this.echo("<div class='failedPass'>root</div>");
                                                    setTimeout(() => {
                                                        this.echo("<div class='failedPass'>toor</div>");
                                                        setTimeout(() => {
                                                            this.echo("<div class='failedPass'>admin</div>");
                                                            setTimeout(() => {
                                                                this.echo("<div class='failedPass'>SecurePassword</div>");
                                                                setTimeout(() => {
                                                                    this.echo("<div class='failedPass'>password_1</div>");
                                                                    setTimeout(() => {
                                                                        this.echo("<div class='failedPass'>qwerty</div>");
                                                                        setTimeout(() => {
                                                                            this.echo("<div class='failedPass'>1q2w3e</div>");
                                                                            setTimeout(() => {
                                                                                this.echo("<div class='SuccessPass'>SuperSecretRootPassword123!@#_</div>");
                                                                                this.echo("------------------------------------------");
                                                                                this.echo("Found password: SuperSecretRootPassword123!@#_");
                                                                                terminal.set_prompt(this.currentUsr + '@panos:' + this.currentDir + '$').resume();
                                                                            }, 500)
                                                                        }, 500)
                                                                    }, 500)
                                                                }, 500)
                                                            }, 500)
                                                        }, 500)
                                                    }, 500)
                                                }, 500)
                                            }, 500)
                                        }, 500)
                                    }, 500)
                                }, 1000)
                            }, 1000);                            
                        }
                    }                
                }
                else if (this.currentDir == "~/Photos") {
                    if (hashfile == null || wordlist == null) {
                        this.echo("You have to add the hash file and a wordlist. Usage bruteforcer [hashfile] [wordlist].")
                    }
                    else {
                        if (hashfile !== "../hash.txt" || hashfile !== "~/hash.txt") {
                            this.echo("Couldn't find the hash file given.")
                        }
                        if (wordlist !== "wordlist.xml") {
                            this.echo("Couldn't find the wordlist file given");
                        }
                        if (hashfile == "../hash.txt" || hashfile == "~/hash.txt" && wordlist == "wordlist.xml" ) {
                            this.set_prompt('').pause(true)
                            this.echo("------------------------------------------");
                            this.echo("Bruteforcer v1.5");
                            setTimeout(() => {
                                this.echo("Reading wordlist");
                                setTimeout(() => {
                                    this.echo("<div class='failedPass'>password</div>");
                                    setTimeout(() => {
                                        this.echo("<div class='failedPass'>password123</div>");
                                        setTimeout(() => {
                                            this.echo("<div class='failedPass'>passwd</div>");
                                            setTimeout(() => {
                                                this.echo("<div class='failedPass'>12345678</div>");
                                                setTimeout(() => {
                                                    this.echo("<div class='failedPass'>root</div>");
                                                    setTimeout(() => {
                                                        this.echo("<div class='failedPass'>toor</div>");
                                                        setTimeout(() => {
                                                            this.echo("<div class='failedPass'>admin</div>");
                                                            setTimeout(() => {
                                                                this.echo("<div class='failedPass'>SecurePassword</div>");
                                                                setTimeout(() => {
                                                                    this.echo("<div class='failedPass'>password_1</div>");
                                                                    setTimeout(() => {
                                                                        this.echo("<div class='failedPass'>qwerty</div>");
                                                                        setTimeout(() => {
                                                                            this.echo("<div class='failedPass'>1q2w3e</div>");
                                                                            setTimeout(() => {
                                                                                this.echo("<div class='SuccessPass'>SuperSecretRootPassword123!@#_</div>");
                                                                                this.echo("------------------------------------------");
                                                                                this.echo("Found password: SuperSecretRootPassword123!@#_");
                                                                                terminal.set_prompt(this.currentUsr + '@panos:' + this.currentDir + '$').resume();
                                                                            }, 500)
                                                                        }, 500)
                                                                    }, 500)
                                                                }, 500)
                                                            }, 500)
                                                        }, 500)
                                                    }, 500)
                                                }, 500)
                                            }, 500)
                                        }, 500)
                                    }, 500)
                                }, 1000)
                            }, 1000);                            
                        }
                    }               
                }                   
            },
            su: function(user, passwd) {
                if (user == null || passwd == null) {
                    this.echo('Please provid user and password for the user. Usage su [user] [password]');
                }
                else {
                    if (user !== "root") {
                        this.echo("<div class='error'>User "+user+" does not exist.</div>")
                    }
                    else {
                        const hashedPasswed = CryptoJS.MD5(passwd).toString();
                        if (hashedPasswed == "34d7f98e9e8ef3d465cd9f04ef954cef") {
                            this.currentUsr = 'root'
                            this.set_prompt(this.currentUsr+'@panos:'+this.currentDir+'$ ')
                        }
                        else {
                            this.echo("<div class='error'>Authentication error. The password is incorrect.</div>")
                        }

                    }
                }

            },
            submitFlag: function(flag) {
	        if (flag == null) {
	           this.echo("<div class='error'>This command takes two argument. Usage: submitFlag [flag].</div>")
	        }
	        else {
		    let md5_flag = CryptoJS.MD5(flag);
	            if (md5_flag == "c6f86db0b0cda1573d8149a6ba4161e9") {
			/*$.ajax({
			    type: "POST",
			    url: "winner.php",
			    data: {'name':name },
			    success: function(data) {
				console.log(data);
			        if (data == "Appended") {
				    console.log("Congrats " + name +"!!! You are a real tech geek.");
				}
				else if (data == "Exists"){
				    this.echo("<div class='error'>"+name + " has already submitted the flag. Use the command with a different name.</div>");
				}
				else {
				    console.log("Error");
				}
			    }
			});*/
			this.echo("Congrats!!! You are a real tech geek.");
	            }
	            else {
	                this.echo("Incorrect flag! Make sure you found the correct flag and there are no typos.")
	            }
                }
            },
            bash: function(file) {
                if (file == null) {
                    this.echo("<div class='error'>Please specify the file to execute!</div>")
                }
                else {
                    if (this.currentDir == "~/important" && file == "message.sh") {
                        this.exec("clear");
                        this.set_prompt("");
                        setTimeout(() => {
                            this.set_prompt("").pause(true);
                            this.echo("<div class='msg1'>Hello there</div>");
                            setTimeout(() => {
                                document.getElementsByClassName("msg1")[0].style.borderRight = "transparent";
                                this.echo("<div class='msg2'>I was trying to escalate my privileges to root however I couldn't find the password for it</div>")
                                setTimeout(() => {
                                    document.getElementsByClassName("msg2")[0].style.borderRight = "transparent";
                                    this.echo("<div class='msg3'>I managed to find the hash for the root password and I stored it in the ~ directory</div>")
                                    setTimeout(() => {
                                        document.getElementsByClassName("msg3")[0].style.borderRight = "transparent";
                                        this.echo("<div class='msg4'>Maybe if you brute force it with bruteforcer you can find the password in plain text</div>")
                                        setTimeout(() => {
                                            document.getElementsByClassName("msg4")[0].style.borderRight = "transparent";
                                            this.echo("<div class='msg5'>Good luck!</div>")
                                            setTimeout(() => {
                                                document.getElementsByClassName("msg5")[0].style.borderRight = "transparent";
                                                this.set_prompt(this.currentUsr+"@panos:"+this.currentDir+"$ ").resume();
                                            }, 1500)
                                        }, 5200)
                                    }, 5150)
                                }, 5500)
                            }, 1550)
                        }, 1000)
                    } else {
                        this.echo("No such file to execute.")
                    }
                }
            },
            fim: function(file) {
                if (file == null) {
                    this.echo("You should provide the image to display. Usage fim [image]")
                }
                else {
                    if (this.currentDir == "~/Photos" && file == "img.png") {
                        this.set_prompt("").pause(true);
                        this.echo("<a href='https://www.youtube.com/watch?v=dQw4w9WgXcQ'><img src='https://c.tenor.com/x8v1oNUOmg4AAAAd/rickroll-roll.gif' target='_blank' title='U just got Rick Rolled!' height='500' width='500' id='RickRoll'/></a>");
                        this.echo(`<audio id='music' src="assets/RickRoll.mp3" autoplay>`)
                        const sound = document.getElementById("music");
                        music.volume = 1;
                        const img = document.getElementById("RickRoll");
                        const fadeAudio = setInterval(() => {
                        const fadePoint = 15;
                        if ((sound.currentTime >= fadePoint) && (sound.volume !== 0)) {
                            sound.volume -= 0.1
                        }

                        if (sound.volume < 0.003) {
                            clearInterval(fadeAudio);
                            this.set_prompt(this.currentUsr+"@panos:"+this.currentDir+"$ ").resume();
                        }
                        }, 200);
                    }
                    else {
                        this.echo("No such file or directory")
                    }                    
                }
            },
            exit: function() {
                this.echo("Goodbye "+this.currentUsr);
                this.set_prompt("").pause();
                window.location.replace("/");
            },
        }, {
            prompt: '',
            checkArity: false,
            greetings: false,
            history: true,
            clear: true,
            raw: true,
            tabindex: 1,
            tabs: 4,
            historySize: 60,
            scrollObject: null,
            onInit: function(){
                this.currentDir = "~"
                this.currentUsr = "<?php echo $user_name?>";
                this.set_prompt('');
                setTimeout(() => {
                    terminal.set_prompt('').pause(true);
		    let characters = 10 + this.currentUsr.toString().length;
                    let timedisplayed =  characters / 20 * 1000;
                    let timedisplayedS = timedisplayed / 1000;

		    let characters2 = 18 + this.currentUsr.toString().length;
                    let timedisplayed2 =  characters2 / 20 * 1000;
                    let timedisplayedS2 = timedisplayed2 / 1000;
                    terminal.echo("<div class='greeting1'>login as: "+terminal.currentUsr+"</div>");
		    document.getElementsByClassName("greeting1")[0].style.width = characters.toString()+"ch";
                    document.getElementsByClassName("greeting1")[0].style.animation = "typing "+timedisplayedS.toString()+"s steps("+characters.toString()+"), blink .5s step-end infinite alternate";
                    setTimeout(() => {
                        document.getElementsByClassName("greeting1")[0].style.borderRight = "transparent";
                        terminal.echo("<div class='greeting2'>"+terminal.currentUsr+"'s password: *****</div>");
                        document.getElementsByClassName("greeting2")[0].style.width = characters2.toString()+"ch";
                        document.getElementsByClassName("greeting2")[0].style.animation = "typing "+timedisplayedS2.toString()+"s steps("+characters.toString()+"), blink .5s step-end infinite alternate";
                        setTimeout(() => {
                            document.getElementsByClassName("greeting2")[0].style.borderRight = "transparent";
                            terminal.echo("<div class='greeting3'>Welcome to Linux v1 (GNU/Linux 4.15.0-36-generic x86_64)</div>")
                            setTimeout(() => {
                                document.getElementsByClassName("greeting3")[0].style.borderRight = "transparent";
                                terminal.echo("<div class='greeting4'>Type 'help' if you need it</div>");
                                setTimeout(() => {
                                document.getElementsByClassName("greeting4")[0].style.borderRight = "transparent";
                                    terminal.set_prompt(terminal.currentUsr+'@panos:'+terminal.currentDir+'$ ').resume();
                                }, 2300)
                            }, 3800)
                        }, timedisplayed2 + 1000)
                    }, timedisplayed + 1000)
                }, 1000) 
            }
        });
    </script>
</body>
</html>
