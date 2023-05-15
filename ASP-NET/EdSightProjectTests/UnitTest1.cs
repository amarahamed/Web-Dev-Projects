using EdSight.Controllers;
using EdSight.Data;
using EdSight.Models;
using Microsoft.AspNetCore.Mvc;
using Microsoft.EntityFrameworkCore;
using Microsoft.VisualStudio.TestTools.UnitTesting;
using System.Collections.Generic;


namespace EdSightProjectTests
{
    [TestClass]
    public class UnitTest1
    {
        private ApplicationDbContext _context;
        PostsController controller;
        List<Post> posts = new List<Post>();
            
        // this method runs automatically for all tests 
        [TestInitialize]
        public void TestInitialize()
        {
            // configuring new in memory database 
            var op = new DbContextOptionsBuilder<ApplicationDbContext>().UseInMemoryDatabase(System.Guid.NewGuid().ToString()).Options;

            _context = new ApplicationDbContext(op);

            // mock posts - to tests
            posts.Add(new Post
            {
                PostId = 101,
                Caption = "Lorem Ipsum is simply dummy text",
                Content = "it is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout.",
                Location = "Somewhere"
            });

            posts.Add(new Post
            {
                PostId = 202,
                Caption = "Lorem Ipsum has been the industry's standard dummy text ever since the 1500s",
                Content = "The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters",
                Location = "ASP NET"
            });

            posts.Add(new Post
            {
                PostId = 303,
                Caption = "It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged.",
                Content = "Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text",
                Location = "London"
            });

            posts.Add(new Post
            {
                PostId = 523,
                Caption = "more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.",
                Content = "There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don't look even slightly believable",
                Location = "Barrie"
            });

            foreach(var post in posts)
            {
                _context.Posts.Add(post);
            }

            _context.SaveChanges();

            // create the controller by passing th db obj 
            controller = new PostsController(_context);
        }

        #region Delete 

        [TestMethod] 
        public void DeleteInvalidView()
        {
            // act 
            var result = (ViewResult)controller.Delete(null).Result;

            // assert expected - 404 page 
            Assert.AreEqual("404", result.ViewName);
        }

        [TestMethod]
        public void DeleteInvalidParameter404View()
        {
            // act 
            var result = (ViewResult)controller.Delete(203).Result;

            // assert expected - 404 page 
            Assert.AreEqual("404", result.ViewName);
        }

        [TestMethod]
        public void DeleteLoadValidView()
        {
            // act 
            var result = (ViewResult)controller.Delete(303).Result;

            // assert - load view 
            Assert.AreEqual("Delete", result.ViewName);
        }

        [TestMethod]
        public void DeletePostSuccess()
        {
            // act
            var result = (ViewResult)controller.Delete(523).Result;

            Assert.AreEqual(posts[3], result.Model);
        }



        #endregion

        #region Details

        [TestMethod]
        public void DetailsIdNullLoads404()
        {
            // act 
            var result = (ViewResult)controller.Details(null).Result;

            // assert 
            Assert.AreEqual("404", result.ViewName);
        }

        [TestMethod]
        public void DetailsInvalidIdLoad404()
        {
            // act 
            var result = (ViewResult)controller.Details(526).Result;

            // assert 
            Assert.AreEqual("404", result.ViewName);
        }

        [TestMethod]
        public void DetailsValidIdLoadProduct()
        {
            var result = (ViewResult)controller.Details(101).Result;

            Assert.AreEqual(posts[0], result.Model);
        }

        [TestMethod]
        public void DetailsValidIdLoadView()
        {
            var result = (ViewResult)controller.Details(101).Result;

            Assert.AreEqual("Details", result.ViewName);
        }

        #endregion


    }
}
