<?php

namespace Neducatio\UserBundle\Features\Context;

use Common\Features\Context\BaseSubContext;
use Neducatio\UserBundle\Entity\UserManager;
use Neducatio\UserBundle\Features\PageObject\ActivatePage;
use Neducatio\UserBundle\Features\PageObject\AddNewUserPage;
use Neducatio\UserBundle\Features\PageObject\DashboardPage;
use Neducatio\UserBundle\Features\PageObject\PermissionPage;
use Neducatio\UserBundle\Features\PageObject\ListingUsersPage;
use Neducatio\UserBundle\Features\PageObject\LoginPage;
use Neducatio\MenuBundle\Features\PageObject\MenuPage;
use Neducatio\BlogBundle\Features\PageObject\BlogPostIndexPage;

use RuntimeException;
use Symfony\Component\Translation\Tests\String;


/**
 * Feature context.
 *
 * @SuppressWarnings(PHPMD.ExcessivePublicCount)
 */
class UserContext extends BaseSubContext
{
    /**
     * Do sth.
     *
     * @param string $login User login
     *
     * @Given /^there is "([^"]*)" account$/
     */
    public function thereIsAccount($login)
    {
        $userManager = new UserManager($this->kernel->getContainer()->get('doctrine')->getManager());
        if (!$userManager->checkUserExists($login)) {
          throw new \RuntimeException;
        }
    }

    /**
     * Do sth.
     *
     * @When /^I go to Login page$/
     * @Given /^I am on Login page$/
     */
    public function iGoToLoginPage()
    {
        $this->getMainContext()->visit("/login");
        $this->setPage(new LoginPage($this->getBrowserPage()));
    }

    /**
     * Do sth.
     *
     * @param string $login user login
     *
     * @Given /^I fill the username field with "([^"]*)"$/
     */
    public function iFillTheUsernameFieldWith($login)
    {
        $this->getPage()->fillUsernameField($login);
    }

    /**
     * Do sth.
     *
     * @param String $pass password
     *
     * @Given /^I fill the password field with correct password$/
     */
    public function iFillThePasswordFieldWithCorrectPassword($pass = "test")
    {
        $this->getPage()->fillPasswordField($pass);
    }

    /**
     * Do sth.
     *
     * @Given /^I click Log in button$/
     */
    public function iClickLogInButton()
    {
         $this->getPage()->clickLoginButton();
    }

    /**
     * Do sth.
     *
     * @Then /^I should see cms dashboard page$/
     */
    public function iShouldSeeCmsDashboardPage()
    {
      $this->setPage(new DashboardPage($this->getBrowserPage()));
    }


     /**
     * Do sth.
     *
     * @param string $login user login
     *
     * @Given /^there is "([^"]*)" admin account$/
     */
    public function thereIsAdminAccount($login)
    {
         $userManager = new UserManager($this->kernel->getContainer()->get('doctrine')->getManager());
         assertTrue($userManager->isSuperAdmin($login));
    }

    /**
     * Do sth.
     *
     * @param string $login user login
     *
     * @Given /^a user account "([^"]*)"$/
     */
    public function userAccount($login)
    {
        $userManager = new UserManager($this->kernel->getContainer()->get('doctrine')->getManager());
        assertTrue($userManager->isUser($login));
    }

    /**
     * Do sth.
     *
     * @param string $login user login
     *
     * @Given /^I log in as "([^"]*)" account into Dashboard page$/
     */
    public function iLogInAsAccountIntoDashboardPage($login)
    {
        $this->iFillTheUsernameFieldWith($login);
        $this->iFillThePasswordFieldWithCorrectPassword();
        $this->iClickLogInButton();
        $this->setPage(new DashboardPage($this->getBrowserPage()));
    }

    /**
     * Do sth.
     *
     * @param string $node node to delete
     *
     * @When /^I click "([^"]*)" node in main menu$/
     */
    public function iClickNodeInMainMenu($node)
    {
        //dsahboard page
        $this->getPage()->clickNodeInMainMenu($node);
        if ("Users" === $node) {
        $this->iAmOnAdminListingUsersPanel();
        } elseif ("Menu structure" === $node) {
          $this->iAmOnMenuStructurePanel();
        } elseif (in_array($node, array("Blog", "Articles"))) {
          $this->iAmOnBlogPostIndexPagePanel();
        }
    }

    /**
     * Do sth.
     *
     * @Then /^I go to Listing users panel$/
     */
    public function iShouldGoToListingUsersPanel()
    {
        $this->setPage(new ListingUsersPage($this->getBrowserPage()));
    }


    /**
     * Do sth.
     *
     * @Given /^I am on admin Listing users panel$/
     */
    public function iAmOnAdminListingUsersPanel()
    {
        $this->setPage(new ListingUsersPage($this->getBrowserPage()));
    }
    /**
     * Do sth.
     *
     * @Given /^I am on menu structure panel$/
     */
    public function iAmOnMenuStructurePanel()
    {
        $this->setPage(new MenuPage($this->getBrowserPage()));
    }

    /**
     * Do sth.
     *
     * @Given /^I am on blog panel$/
     */
    public function iAmOnBlogPostIndexPagePanel()
    {
        $this->setPage(new BlogPostIndexPage($this->getBrowserPage()));
    }

    /**
     * Do sth.
     *
     * @param string $login user login
     *
     * @When /^I click delete button at "([^"]*)" row$/
     */
    public function iClickDeleteButtonAtRow($login)
    {
        $this->getPage()->clickDeleteButtonAtRow($login);
    }

    /**
     * Do sth.
     *
     * @param string $login user login
     *
     * @Then /^"([^"]*)" should be delete$/
     */
    public function shouldBeDelete($login)
    {
        assertTrue($this->getPage()->searchDeletedUser($login));
    }

    /**
     *  I click menu button
     *
     * @When /^I click menu button$/
     */
    public function iClickMenuButton()
    {
        $this->getPage()->clickMenuButton();
        $this->setPage(new MenuPage($this->getBrowserPage()));
    }

    /**
     * Create link to visit
     *
     * @param string $currentUrl current Url
     *
     * @return string newLink
     */
    public function createLinkToVisit($currentUrl)
    {
      $removeLink = rtrim($this->getMainContext()->getMinkParameter('base_url'), '/') . '/';
      $newLink = str_replace($removeLink, "", $currentUrl);

      return $newLink;
    }

    /**
     * Check if this user can be deleted
     *
     * @param string $username username
     *
     * @Then /^I should not see delete button next to "([^"]*)"$/
     */
    public function iShouldNotSeeDeleteButtonNextTo($username)
    {
        if ($this->getPage()->isDeletedButtonVisible($username)) {
          throw new \Exception;
        }
    }

    /**
     * I confirm delete button
     *
     * @Given /^I confirm deleting$/
     */
    public function iConfirmDeleting()
    {
        $this->getPage()->confirmDeleting();
    }

     /**
     * Do sth.
     *
     * @param string $username username
     * @param string $userId   user id
     *
     * @Given /^a "([^"]*)" with id "([^"]*)" user account not exist$/
     */
    public function userAccountNotExist($username, $userId)
    {
        $userManager = new UserManager($this->kernel->getContainer()->get('doctrine')->getManager());
        $userManager->makeSureThatUserNotExist($username, $userId);
    }

    /**
     * Do sth.
     *
     * @param string $userId userid
     *
     * @When /^I try to delete user account with id "([^"]*)"$/
     */
    public function iTryToDeleteUserAccount($userId)
    {
        $this->getMainContext()->visit("profile/delete/".$userId);
    }

    /**
     * Do sth.
     *
     * @Then /^I should see message that user not exist$/
     */
    public function iShouldSeeMessageThatUserNotExist()
    {
        assertTrue($this->getPage()->checkMessageExistThatUserNotExist());
    }


    /**
     * I click link
     *
     * I click link
     *
     * @param String $linkName link name
     *
     * @Given /^I click "([^"]*)" link$/
     */
    public function iClickLink($linkName)
    {
         $this->setPage(new ListingUsersPage($this->getBrowserPage()));
         $this->getPage()->clickLink($linkName);
    }

    /**
     * I register user with email and username
     *
     * @param String $email    email
     * @param String $username username
     *
     * @Given /^I register user with email "([^"]*)" and username "([^"]*)"$/
     */
    public function iRegisterUserWithEmailAndUsername($email, $username)
    {
        $this->setPage(new AddNewUserPage($this->getBrowserPage()));
        $this->getPage()->submitRegisterForm($email, $username);
    }

    /**
     * User should receive email
     *
     * @param String $email email
     *
     * @Then /^User "([^"]*)" should receive email$/
     */
    public function userShouldReceiveEmail($email)
    {
        $em = $this->kernel->getContainer()->get('doctrine')->getManager();
        $emailRepository =  $em->getRepository('NeducatioUserBundle:Email');
        $lastEmail = $emailRepository->getLastEmail();
        $to = $lastEmail->getToField();
        $keys = array_keys($to);
        $addressFromEmail = array_shift($keys);
        assertEquals($email, $addressFromEmail);
    }

    /**
     * getTokenByUsername
     *
     * @param string $username username
     *
     * @return string token
     */
    public function getTokenByUsername($username)
    {
      $em = $this->kernel->getContainer()->get('doctrine')->getManager();
      $user =  $em->getRepository('NeducatioUserBundle:User')-> findOneByUsername($username);

      return $user->getConfirmationToken();
    }

    /**
     * userReceivedActivationEmail
     *
     * @param string $username username
     *
     * @Given /^User "([^"]*)" received activation email$/
     */
    public function userReceivedActivationEmail($username)
    {
      assertNotNull($this->getTokenByUsername($username));
    }

    /**
     * userClickActivatingLink
     *
     * @param string $username username
     *
     * @When /^User "([^"]*)" click activating link$/
     */
    public function userClickActivatingLink($username)
    {
      $this->getMainContext()->visit("profile/activate/".$this->getTokenByUsername($username));
    }

    /**
     * User click activating link from email
     *
     * @Given /^User click activating link from email$/
     */
    public function userClickActivatingLinkFromEmail()
    {

        $em = $this->kernel->getContainer()->get('doctrine')->getManager();
        $emailRepository =  $em->getRepository('NeducatioUserBundle:Email');
        $lastEmail = $emailRepository->getLastEmail();
        $match = array();
        if (!preg_match('/(?<=)http[^><]+?(?=<|$)/', $lastEmail->getBody(), $match)) {
          throw new \Exception();
        }
        $this->getMainContext()->visit($this->createLinkToVisit($match[0]));
    }

    /**
     * User pass new password
     *
     * @param String $pass password
     *
     * @Given /^User pass new password "([^"]*)"$/
     */
    public function userPassNewPassword($pass)
    {
        $this->setPage(new ActivatePage($this->getBrowserPage()));
        $this->getPage()->submitNewPassword($pass);
    }

    /**
     * User should see cms dashboard page
     *
     * @Given /^User should see cms dashboard page$/
     */
    public function userShouldSeeCmsDashboardPage()
    {
        $this->iShouldSeeCmsDashboardPage();
    }

    /**
     * I log in as account with password
     *
     * @param String $login login
     * @param String $pass  password
     *
     * @Then /^I log in as "([^"]*)" account with password "([^"]*)"$/
     */
    public function iLogInAsAccountWithPassword($login, $pass)
    {
        $this->setPage(new LoginPage($this->getBrowserPage()));
        $this->iFillTheUsernameFieldWith($login);
        $this->iFillThePasswordFieldWithCorrectPassword($pass);
        $this->iClickLogInButton();
    }

    /**
     * Go to login page and log as given user
     *
     * @param string $login User login
     *
     * @When /^I log in as "([^"]*)" user$/
     */
    public function iLogInAsUser($login)
    {
        $this->getMainContext()->visit("/login");
        $this->iLogInAsAccountWithPassword($login, "test");
    }

    /**
     * Do sth.
     *
     * @param String $phrase phrase to search
     *
     * @Given /^I search users with "([^"]*)"$/
     */
    public function iSearchUsersWith($phrase)
    {
        $this->setPage(new ListingUsersPage($this->getBrowserPage()));

        $this->getPage()->searchUsers($phrase);
    }

    /**
     * Do sth.
     *
     * @param string $user1 user1
     * @param string $user2 user2
     *
     * @Then /^I should see list with "([^"]*)" and "([^"]*)" users$/
     */
    public function iShouldSeeListWithAndUsers($user1, $user2)
    {
        if (!$this->getPage()->hasUsers(array($user1, $user2))) {
          throw new RuntimeException;
        }
    }

    /**
     * Do sth.
     *
     * @param string $user1 user1
     * @param string $user2 user2
     *
     * @Given /^I should see list without "([^"]*)" and "([^"]*)" users$/
     */
    public function iShouldSeeListWithoutAndUsers($user1, $user2)
    {
        if (!$this->getPage()->hasntUsers(array($user1, $user2))) {
          throw new RuntimeException;
        }
    }


    /**
      * Loged in as admin at panel
      *
      * @param string $panel panel
      *
      * @Given /^I am logged in as an admin at "([^"]*)" panel$/
      */
    public function iAmLoggedInAsAnAdminAtPanel($panel)
    {
        $this->getMainContext()->visit("/login");
        $this->setPage(new LoginPage($this->getBrowserPage()));
        $this->getPage()->iAmLogedAsAdmin();
        $this->setPage(new DashboardPage($this->getBrowserPage()));
        $this->iClickNodeInMainMenu($panel);
    }

     /**
      * Loged in as super admin at panel
      *
      * @param string $panel panel
      *
      * @Given /^I am logged in as an super admin at "([^"]*)" panel$/
      */
    public function iAmLoggedInAsAnSuperAdminAtPanel($panel)
    {
        $this->getMainContext()->visit("/login");
        $this->setPage(new LoginPage($this->getBrowserPage()));
        $this->getPage()->iAmLogedAsSuperAdmin();
        $this->setPage(new DashboardPage($this->getBrowserPage()));
        $this->iClickNodeInMainMenu($panel);
    }

    /**
     * Log in as given user and go to given panel
     *
     * @param string $username User to log in
     * @param string $panel    panel
     *
     * @Given /^I logged in as "([^"]*)" at "([^"]*)" panel$/
     */
    public function iLoggedInAsAtPanel($username, $panel)
    {
        $this->getMainContext()->visit("/login");
        $this->setPage(new LoginPage($this->getBrowserPage()));
        $this->getPage()->logInAsGivenUser($username);
        $this->setPage(new DashboardPage($this->getBrowserPage()));
        $this->iClickNodeInMainMenu($panel);
    }

    /**
     * Do sth.
     *
     * @param string $userName userName
     *
     * @Then /^I shouldn\'t see change permissions button near "([^"]*)"$/
     */
    public function iShouldnTSeeChangePermissionsButtonNear($userName)
    {
        assertFalse($this->getPage()->isPermissionsButtonVisible($userName));
    }

    /**
     * Do sth.
     *
     * @param string $username username
     *
     * @When /^I click change permission button on "([^"]*)" user$/
     */
    public function iClickChangePermissionButtonOnUser($username)
    {
       $this->getPage()->clickChangePermissiosnButtonOnUser($username);
       $this->setPage(new PermissionPage($this->getBrowserPage()));
    }

    /**
     * I create user type.
     *
     * @param string $username username
     *
     * @When /^I create "([^"]*)" user type$/
     */
    public function iCreateUserType($username)
    {
      $this->iClickLink("Create account");
      $this->iRegisterUserWithEmailAndUsername($username, $username);
    }

    /**
     * I go to profile create.
     *
     * @When /^I go to user creation$/
     */
    public function iGoToUserCreation()
    {
      $this->getMainContext()->visit("/profile/create");
      $this->setPage(new AddNewUserPage($this->getBrowserPage()));
      sleep(3);
    }


    /**
     * Check if current page is permissions page for given user
     *
     * @param string $username Username
     *
     * @Then /^I should see edit permissions page for user "([^"]*)"$/
     */
    public function iShouldSeeEditPermissionsPageForUser($username)
    {
        $this->setPage(new PermissionPage($this->getBrowserPage()));
        $userId = $this->getEntityManager()->getRepository('NeducatioUserBundle:User')->findOneByUsername($username)->getId();
        $explodedCurrentUrl = explode('/', $this->getMainContext()->getSession()->getCurrentUrl());
        assertEquals($userId, array_pop($explodedCurrentUrl));
    }

    /**
     * Check If I see lock button.
     *
     * @param string $username username
     *
     * @Then /^I should see lock button next to "([^"]*)"$/
     */
    public function iShouldSeeLockButtonNextTo($username)
    {
      assertTrue($this->getPage()->isLockButtonVisible($username));
    }


    /**
     * Check If I see lock button next to given user
     *
     * @param string $username username
     *
     * @Then /^I should not see lock button next to "([^"]*)"$/
     */
    public function iShouldNotSeeLockButtonNextTo($username)
    {
      assertFalse($this->getPage()->isLockButtonVisible($username));
    }


    /**
     * Checks if three given accounts exist
     * 
     * @param string $user1 user1
     * @param string $user2 user2
     * @param string $user3 user3
     *
     * @Given /^There are "([^"]*)" and "([^"]*)" and "([^"]*)" accounts$/
     */
    public function thereAreAndAndAccounts($user1, $user2, $user3)
    {
        $this->userAccount($user1);
        $this->userAccount($user2);
        $this->userAccount($user3);
    }

    /**
     * Checks if three given users are listed in order
     * 
     * @param string $user1 user1
     * @param string $user2 user2
     * @param string $user3 user3
     *
     * @Then /^I should see users in order "([^"]*)" and "([^"]*)" and "([^"]*)"$/
     */
    public function iShouldSeeUsersInOrderAndAnd($user1, $user2, $user3)
    {
      assertSame($this->getPage()->getUserNameInOrder(0), $user1);
      assertSame($this->getPage()->getUserNameInOrder(1), $user2);
      assertSame($this->getPage()->getUserNameInOrder(2), $user3);
    }

}
