page = PAGE
page {

    10 = TEMPLATE
    10 { 
    
        template = FILE
        template.file = fileadmin/html/template.html 

        subparts {
        
            nav_col = HMENU
            nav_col {
            
                1 = TMENU
                1 {
                
                    NO.allWrap = <div class="menu1-level1-no"> | </div>
                        # Enable active state and set properties:
                    ACT = 1
                    ACT.allWrap = <div class="menu1-level1-act"> | </div>
                
                }
            
            }

            
            content_col < styles.content.get
        
        }

    }

}