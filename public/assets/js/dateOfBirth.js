console.log("dateOfBirth.js loading");

var formData = new FormData();
var birth;
$(document).ready(function () {

    // Name initials
    const txtFullNameInput = document.getElementById("full_name");
    txtFullNameInput.addEventListener("input", function() {
        this.value = this.value.replace(/\s+/g, " ");
    });
    const fullNameInput = document.getElementById('full_name');
    const initNameInput = document.getElementById('name_initials');

    fullNameInput.addEventListener('blur', () => {
        const fullName = fullNameInput.value;
        const words = fullName.split(' ');
        //const initialsExceptLast = words.slice(0, -1).map(word => word.charAt(0)).join('.');
        const initialsExceptLast = words.slice(0, -1).map(word => word.charAt(0).toUpperCase()).join('.');
        const initialsExceptLast2 = words.slice(0, -2).map(word => word.charAt(0).toUpperCase()).join('.');
        const lastWord = words[words.length - 1];
        const lastWord2 = words[words.length - 2];
        
        if (lastWord.trim() === '') {
            initNameInput.value = initialsExceptLast2 + ' ' + lastWord2;
          
        } else {
            initNameInput.value = initialsExceptLast + ' ' + lastWord;
        }
    });

    //..Birth Day

    const idNoInput = document.getElementById('national_id_number');
    const birthdayInput = document.getElementById('date_of_birth');

    //200500300356  1 3
        
        idNoInput.addEventListener('blur', () => {
            const idNo = idNoInput.value;
    
            if (idNo.length == 10) {
                const birthYear = idNo.substring(0, 2);
                const birthMonth =parseInt(idNo.substring(2, 5));

                
                if(birthMonth<=500){
                   if(birthMonth<=31){
                    var Month = "01"
                     birth = 0+birthMonth
                   
                   }else if(birthMonth<=60){
                    var Month = "02"
                     birth = birthMonth-31
                   
                   
                   }else if(birthMonth<=91){
                    var Month = "03"
                     birth = birthMonth-60
                   
                   
                   }else if(birthMonth<=121){
                    var Month = "04"
                     birth = birthMonth-91
                   
                   
                  
                   }else if(birthMonth<=152){
                    var Month = "05"
                    var birth = birthMonth-121
                   
                   
                   
                   }else if(birthMonth<=182){
                    var Month = "06"
                     birth = birthMonth-152
                 

                   }else if(birthMonth<=213){
                    var Month = "07"
                     birth = birthMonth-182
                   

                   }else if(birthMonth<=244){
                    var Month = "08"
                     birth = birthMonth-213
                    

                   }else if(birthMonth<=274){
                    var Month = "09"
                     birth = birthMonth-244
                   
                   
                  
                   }else if(birthMonth<=305){
                    var Month = "10"
                     birth = birthMonth-274
                    
                   
                    
                   }else if(birthMonth<=335){
                    var Month = "11"
                     birth = birthMonth-305

                  
                   }else if(birthMonth>=335){
                    var Month = "12"
                     birth = birthMonth-335
                   
                   
                   }
                   // FeMale
                }else{
                 var bithM =   birthMonth-500

                 if(bithM<=31){
                    var Month = "01"
                     birth = 0+bithM
                   
                   

                   }else if(bithM<=60){
                    var Month = "02"
                     birth = bithM-31
                   
                   
                   }else if(bithM<=91){
                    var Month = "03"
                     birth = bithM-60
                   
                   
                   }else if(bithM<=121){
                    var Month = "04"
                     birth = bithM-91
                   
                   
                  
                   }else if(bithM<=152){
                    var Month = "05"
                    var birth = bithM-121
                   
                   
                   
                   }else if(bithM<=182){
                    var Month = "06"
                     birth = bithM-152
                 

                   }else if(bithM<=213){
                    var Month = "07"
                     birth = bithM-182
                   

                   }else if(bithM<=244){
                    var Month = "08"
                     birth = bithM-213
                    

                   }else if(bithM<=274){
                    var Month = "09"
                     birth = bithM-244
                   
                   
                  
                   }else if(bithM<=305){
                    var Month = "10"
                     birth = bithM-274
                    
                   
                    
                   }else if(bithM<=335){
                    var Month = "11"
                     birth = bithM-305

                  
                   }else if(bithM>=335){
                    var Month = "12"
                     birth = bithM-335
                   
                   
                   }
                      
                }
               // const birthDay = idNo.substring(4, 6);
     const formattedBirthdate = `19${birthYear}-${Month}-${birth.toString().padStart(2, '0')}`;
        birthdayInput.value = formattedBirthdate;
            } else if (idNo.length == 12) {
                const birthYear = idNo.substring(0, 4);
                const birthMonth = parseInt(idNo.substring(4, 7));
               // const birthDay = idNo.substring(6, 8);

              

               if(birthMonth<=500){
                if(birthMonth<=31){
                 var Month = "01"
                  birth = 0+birthMonth
                
                

                }else if(birthMonth<=60){
                 var Month = "02"
                  birth = birthMonth-31
                
                
                }else if(birthMonth<=91){
                 var Month = "03"
                  birth = birthMonth-60
                
                
                }else if(birthMonth<=121){
                 var Month = "04"
                  birth = birthMonth-91
                
                
               
                }else if(birthMonth<=152){
                 var Month = "05"
                 var birth = birthMonth-121
                
                
                
                }else if(birthMonth<=182){
                 var Month = "06"
                  birth = birthMonth-152
              

                }else if(birthMonth<=213){
                 var Month = "07"
                  birth = birthMonth-182
                

                }else if(birthMonth<=244){
                 var Month = "08"
                  birth = birthMonth-213
                 

                }else if(birthMonth<=274){
                 var Month = "09"
                  birth = birthMonth-244
                
                
               
                }else if(birthMonth<=305){
                 var Month = "10"
                  birth = birthMonth-274
                 
                
                 
                }else if(birthMonth<=335){
                 var Month = "11"
                  birth = birthMonth-305

               
                }else if(birthMonth>=335){
                 var Month = "12"
                  birth = birthMonth-335
                
                
                }
                // FeMale
             }else{
              var bithM =   birthMonth-500

              if(bithM<=31){
                 var Month = "01"
                  birth = 0+bithM
                
                

                }else if(bithM<=60){
                 var Month = "02"
                  birth = bithM-31
                
                
                }else if(bithM<=91){
                 var Month = "03"
                  birth = bithM-60
                
                
                }else if(bithM<=121){
                 var Month = "04"
                  birth = bithM-91
                
                
               
                }else if(bithM<=152){
                 var Month = "05"
                 var birth = bithM-121
                
                
                
                }else if(bithM<=182){
                 var Month = "06"
                  birth = bithM-152
              

                }else if(bithM<=213){
                 var Month = "07"
                  birth = bithM-182
                

                }else if(bithM<=244){
                 var Month = "08"
                  birth = bithM-213
                 

                }else if(bithM<=274){
                 var Month = "09"
                  birth = bithM-244
                
                
               
                }else if(bithM<=305){
                 var Month = "10"
                  birth = bithM-274
                 
                
                 
                }else if(bithM<=335){
                 var Month = "11"
                  birth = bithM-305

               
                }else if(bithM>=335){
                 var Month = "12"
                  birth = bithM-335
                
                
                }
            }

            const formattedBirthdate = `${birthYear}-${Month}-${birth.toString().padStart(2, '0')}`;
            birthdayInput.value = formattedBirthdate;

            }
        });

    });