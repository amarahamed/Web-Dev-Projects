using System;
using System.Collections.Generic;
using System.ComponentModel.DataAnnotations;
using System.Linq;
using System.Threading.Tasks;

namespace EdSight.Models
{
    public class Post
    {

        [Display (Name="Post ID")]
        public int PostId { get; set; }

        // this field is not required because the user can post without a caption also 
        public string Caption { get; set; }

        // below field are not required because the user can post just a typed content or a picture 
        public string Picture { get; set; }

        public string Content { get; set; }  

        // location can be empty 
        public string Location { get; set; }


        /*
        // foreign key 
        public int UserId { get; set; }

        // parent reference 
        public User User { get; set; }
        */
        public List<Like> Likes { get; set; }
    }
}
