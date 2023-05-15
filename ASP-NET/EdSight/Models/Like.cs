using System;
using System.Collections.Generic;
using System.ComponentModel.DataAnnotations;
using System.Linq;
using System.Threading.Tasks;

namespace EdSight.Models
{
    public class Like
    {
        [Display(Name ="Like ID")]
        // pk 
        public int LikeId { get; set; }

        // saves the user's id who liked the photo 
        public int TargetId { get; set; }

        // one post has many likes but one like has only one post 
        //Foreign key
        //Post id
        public int PostId { get; set; }

        public Post Posts { get; set; }

        //public User User { get; set; }


    }
}
