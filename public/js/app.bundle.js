webpackJsonp([0],[
/* 0 */,
/* 1 */
/***/ (function(module, exports, __webpack_require__) {

/**
 * Created by jidesakin on 6/29/16.
 */
angular.module('app', [

    // Angular modules
    'ui.router',
    'ngResource',
    'angularCSS',

    // Third party modules
    'truncate',
    'ngSanitize',
    'ngTagsInput',
    'toastr',
    'ui.select',
    'firebase',
    'angular-loading-bar',
    'angularUtils.directives.dirPagination',
    'satellizer',
    'ui.bootstrap',
    'textAngular',
    'angularMoment',
    'environment',
    'ngMaterial',
    'ngFileUpload',
    'angular-input-stars',
    'ngAvatar',
    'ngLetterAvatar',

    // Custom modules
    'userService',
    'settingsService',
    'mentorService',
    'menteeService',
    'mentoringSessionService',
    'noteService',
    's3uploadService',
    'programService',
    'interestService',
    'questionService',
    'replyService',
    'taskService',
    'resourceService',
    'miscService',

    'app.auth',
    'app.routes',
    'app.about',
    'app.home',
    'app.gettingStarted',
    'app.following',
    'app.followers',
    'app.dashboard',
    'app.connect',
    'app.mentoringSession',
    'app.settings',
    'app.notes',
    'app.profile',
    'app.mentors',
    'app.program',
    'app.searchResult',
    'app.interest',
    'app.question',

    ])

    .filter('toTrusted', ['$sce', function ($sce) {
        return function (value) {
            return $sce.trustAsHtml(value);
        };
    }])
    .filter('trusted', ['$sce', function ($sce) {
        return function(url) {
                var video_id = url.split('v=')[1].split('&')[0];
            return $sce.trustAsResourceUrl("https://www.youtube.com/embed/" + video_id);
        };
    }])
    .constant('CONFIG', {
        'API_BSE_URL' : '/api/',
        'FILE_PATH':'/',
        'BASE_URL': '/',

        'FirebaseUrl': 'https://firebase-na.firebaseio.com/',
        'REMOTE_AWS_BUCKET': 'https://s3-us-west-2.amazonaws.com/meetrabbi/',
        'SIZE_LIMIT': 10585760,
        'S3_CREDENTIALS': {
            bucket: 'meetrabbi',
            access_key: 'AKIAJEXMDZOVXOJXSNXA',
            secret_key: '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',
            region: 'us-east-1'
        }
    })
    .controller('AppCtrl', ['$scope', '$auth', '$state', 'UserDataOp', 'CONFIG', function($scope, $auth, $state, UserDataOp, CONFIG){
        $scope.FILE_PATH = CONFIG.FILE_PATH;
        $scope.isAuthenticated = $auth.isAuthenticated();
        $scope.isAMentor = true;

        // Get the private profile of the authenticated user
        UserDataOp.getPrivateProfile(function(response){
            $scope.authUser = response;
            $scope.isAMentor = $scope.authUser.is_a_mentor == 1;
            $scope.initials = response.first_name.charAt() + response.last_name.charAt();
        }, function(){

        });

    }])
    .run(['$rootScope', '$window', function ($rootScope, $window) {

        // $scope.isAuthenticated = $auth.isAuthenticated();
        mixpanel.register({
            'host': window.location.host
        });

        $rootScope.goBack = function () {
            $window.history.back();
        };

    }])
    .factory('searchService', ['$http', 'CONFIG', function($http, CONFIG){

        return {
            doSearch: function(query) {
                return $http({
                    url: CONFIG.API_BSE_URL + 'interest/search',
                    method: "GET",
                    params: {query: query}
                });
            }
        }
    }]);
    
__webpack_require__(2)
__webpack_require__(3);
__webpack_require__(6);
__webpack_require__(13);
__webpack_require__(15);
__webpack_require__(17);
__webpack_require__(19);
__webpack_require__(21);
__webpack_require__(23);
__webpack_require__(25);
__webpack_require__(27);
__webpack_require__(29);
__webpack_require__(34);
__webpack_require__(37);
__webpack_require__(48);
__webpack_require__(50);
__webpack_require__(53);
__webpack_require__(55);
__webpack_require__(57);



/***/ }),
/* 2 */
/***/ (function(module, exports) {

/**
 * Created by jidesakin on 12/6/16.
 */

angular.module('app.routes', [])
    .config(['$stateProvider', '$urlRouterProvider', '$httpProvider', '$locationProvider', '$authProvider', 'envServiceProvider',
        function($stateProvider, $urlRouterProvider, $httpProvider, $locationProvider, $authProvider, envServiceProvider){

            $locationProvider.html5Mode(true);

            envServiceProvider.config({

                domains: {
                    development: ['localhost', 'dev.local'],
                    production: ['meetrabbi.com']
                },
                vars: {
                    development: {
                        apiBaseUrl: '//localhost:8000/api',
                        staticUrl: '//localhost:8000/'
                    },

                    production: {
                        apiUrl: 'https://www.meetrabbi.com/api',
                        staticUrl: '//www.meetrabbi.com/'
                    }
                }

            });


            $authProvider.baseUrl = 'api/';

            $authProvider.signupUrl = 'auth/register';

            $authProvider.facebook({
                clientId: '1682670775322787',
                display: 'popup',
            });

            $authProvider.linkedin({
                clientId: '77ch44vedai0xn'
            });

            $authProvider.twitter({
                clientId: 'RZANZ8cPw1bR0gST1T989EW3k',
                url: '/auth/twitter'
            });

            /*
             * Helper auth functions
             * */
            var skipIfLoggedIn = function skipIfLoggedIn($q, $auth, $location) {
                var deferred = $q.defer();

                if ($auth.isAuthenticated()) {
                    $location.path('/dashboard');
                } else {
                    deferred.resolve();
                }

                return deferred.promise;
            };

            var loginRequired = function loginRequired($q, $location, $auth) {

                var deferred = $q.defer();

                if ($auth.isAuthenticated()) {
                    deferred.resolve();
                } else {
                    localStorage.setItem('prevUrl', $location.path());
                    $location.path('/login');
                }

                return deferred.promise;
            };


            $stateProvider

                .state('app', {
                    // abstract: true,
                    templateUrl: 'app/shared/layouts/app.html',
                    controller: 'AppCtrl'
                })

                .state('access', {
                    templateUrl: 'app/shared/layouts/access.html',
                    abstract: true
                })

                .state('access.login', {
                    url: '/login',
                    views: {
                        '': {
                            templateUrl: 'app/components/auth/login.html',
                            controller: 'LoginCtrl',
                            controllerAs: 'authVm'
                        }
                    },
                    resolve: {
                        skipIfLoggedIn: skipIfLoggedIn
                    }
                })

                .state('logout', {
                    template: null,
                    controller: 'LogoutCtrl'
                })

                .state('access.register', {
                    url: '/register',
                    views: {
                        '': {
                            templateUrl: 'app/components/auth/register.html',
                            controller: 'RegisterCtrl',
                            controllerAs: 'register'
                        }
                    },
                    resolve: {
                        skipIfLoggedIn: skipIfLoggedIn
                    }
                })

                .state('access.forgotPassword', {
                    url: '/forgot-password',
                    templateUrl: 'app/components/auth/forgot-password.html',
                    controller: 'ForgotPasswordCtrl',
                    controllerAs: 'forgotPasswordVm'
                })

                .state('access.resetPassword', {
                    url: '/password/reset/:token',
                    templateUrl: 'app/components/auth/reset-password.html',
                    controller: 'ResetPasswordCtrl',
                    controllerAs: 'resetPasswordVm'
                })

                .state('verifyAccount', {
                    url: '/verify_account/:token',
                    controller: 'VerifyAccountCtrl'
                })

                .state('access.requestInvite', {
                    url: '/request_invite',
                    views: {
                        '': {

                        }
                    }
                })

                .state('access.about', {
                    url: '/about',
                    views: {
                        '': {
                            templateUrl: 'app/components/about/about.html',
                            controller: 'AboutCtrl'
                        }
                    }
                })

                .state('access.learnMore', {
                    url: '/learn_more',
                    views: {
                        '': {
                            templateUrl: 'app/components/learn_more/learn-more.html',
                            controller: 'LoginCtrl',
                            controllerAs: 'authVm'
                        }
                    }
                })

                .state('access.faqs', {
                    url: '/faqs',
                    templateUrl: 'app/components/faqs/faqs.html'
                })

                .state('guest', {
                    url: '/',
                    views:{
                        '': {
                            templateUrl: 'app/components/home/home.html',
                            controller: 'HomeCtrl',
                            controllerAs: 'homeVm'
                        }
                    },
                    resolve: {
                        skipIfLoggedIn: skipIfLoggedIn
                    }
                })

                /* Mentors Section */
                .state('app.mentors', {
                    url: '/people',
                    views:{
                        '': {
                            templateUrl: 'app/components/mentors/mentors.html',
                            controller: 'MentorCtrl',
                            controllerAs: 'mentorsVm'
                        }
                    },
                    resolve: {
                        loginRequired: loginRequired
                    }
                })
            
                /* Getting Started Section */
                .state('gettingStarted', {
                    templateUrl: 'app/components/getting_started/getting-started.html',
                    controller: 'GettingStartedCtrl as gettingStartedVm'
                })

                .state('gettingStarted.profile', {
                    url: '/getting_started/profile',
                    templateUrl: 'app/components/getting_started/profile.getting-started.html',
                    resolve: {
                        loginRequired: loginRequired
                    }
                })

                .state('gettingStarted.interests', {
                    url: '/getting_started/interests',
                    templateUrl: 'app/components/getting_started/interests.getting-started.html',
                    resolve: {
                        loginRequired: loginRequired
                    }
                })

                .state('gettingStarted.connect', {
                    url: '/getting_started/connect',
                    templateUrl: 'app/components/getting_started/connect.getting-started.html',
                    resolve: {
                        loginRequired: loginRequired
                    }
                })

                .state('gettingStarted.becomeAMentor', {
                    url: '/getting_started/become_a_mentor',
                    templateUrl: 'app/components/getting_started/become-a-mentor.html',
                    resolve: {

                    }
                })

                .state('confirm', {
                    url: '/confirm',
                    templateUrl: 'app/views/emailConfirmation.html',
                })
                .state('app.dashboard', {
                    url: '/dashboard',
                    views:{
                        '': {
                            templateUrl: 'app/components/dashboard/dashboard.html',
                            controller: 'DashboardCtrl',
                            controllerAs: 'dashboardVm'
                        },
                        'profileSummary@app.dashboard': {
                            templateUrl: 'app/components/profile/private-profile-summary.html',
                        },
                        'discoverPeople@app.dashboard': {
                            templateUrl: 'app/shared/layouts/people-you-may-know.html',
                        }
                    },
                    resolve: {
                        loginRequired: loginRequired
                    }
                })
                .state('app.myNotes', {
                    url: '/posts/me',
                    views: {
                        '': {
                            templateUrl: 'app/components/notes/my-notes.html',
                            controller: 'NoteCtrl',
                            controllerAs: 'noteVm'
                        }
                    },
                    resolve: {
                        loginRequired: loginRequired
                    }
                })
                .state('app.viewQuestion', {
                    url: '/questions/:id',
                    views: {
                        '': {
                            templateUrl: 'app/components/question/view-question.html',
                            controller: 'QuestionCtrl',
                            controllerAs: 'questionVm'
                        }
                    },
                })
                .state('app.connect', {
                    url: '/connect',
                    views:{
                        '': {
                            templateUrl: 'app/views/authProfileSummary.html',
                        },
                        'discoverPeople@app.notes': {
                            templateUrl: 'app/views/discoverPeople.html',
                        }
                    },
                    resolve: {
                        loginRequired: loginRequired
                    }

                })

                .state('app.viewNote', {
                    url: '/posts/:id/view',
                    views:{
                        '': {
                            templateUrl: 'app/components/notes/view-note.html',
                            controller: 'ViewNoteCtrl',
                            controllerAs: 'viewNoteVm'
                        },
                        'relatedNotes@app.viewNote':{
                            templateUrl: 'app/components/notes/related-notes.html'
                        }
                    },
                    resolve: {
                        loginRequired: loginRequired
                    }

                })

                .state('app.editNote', {
                    url: '/posts/:id/edit',
                    views:{
                        '': {
                            templateUrl: 'app/components/notes/edit-note.html',
                            controller: 'EditNoteCtrl',
                            controllerAs: 'editNoteVm'
                        }
                    },
                    resolve: {
                        loginRequired: loginRequired
                    }

                })

                .state('app.createNote', {
                    url: '/post/create',
                    views:{
                        '': {
                            templateUrl: 'app/components/notes/create-note.html',
                            controller: 'CreateNoteCtrl',
                            controllerAs: 'createNoteVm'
                        }
                    },
                    resolve: {
                        loginRequired: loginRequired
                    }

                })

                // View user private profile
                .state('app.privateProfile', {
                    url: '/profile',
                    views:{
                        '': {
                            templateUrl: 'app/components/profile/private-profile.html',
                            controller: 'PrivateProfileCtrl',
                            controllerAs: 'privateProfileVm'
                        },
                        'profileSummary@app.privateProfile': {
                            templateUrl: 'app/components/profile/private-profile-summary.html',
                        },
                        'socialAccount@app.privateProfile': {
                            templateUrl: 'app/components/profile/social-profile.html',
                        }
                    },
                    resolve: {
                        loginRequired: loginRequired
                    }

                })

                // View user public profile
                .state('app.publicProfile', {
                    url: '/user/:id/profile',
                    views:{
                        '': {
                            templateUrl: 'app/components/profile/public-profile.html',
                            controller: 'PublicProfileCtrl',
                            controllerAs: 'publicProfileVm'
                        },
                        'profileSummary@app.publicProfile':{
                            templateUrl: 'app/components/profile/public-profile-summary.html',
                        },
                        'socialAccount@app.publicProfile':{
                            templateUrl: 'app/components/profile/social-profile.html',
                        }
                    },
                    resolve: {
                        loginRequired: loginRequired
                    }
                })

                // View followers
                .state('app.followers', {

                    url: '/user/:id/followers',
                    views:{
                        '': {
                            templateUrl: 'app/components/followers/followers.html',
                            controller: 'FollowerCtrl'
                        },
                        'profileSummary@app.followers': {

                            templateUrl: 'app/components/profile/public-profile-summary.html',
                        },
                        'discoverPeople@app.followers':{

                            templateUrl: 'app/shared/layouts/people-you-may-know.html',
                        }
                    },
                    resolve: {
                        loginRequired: loginRequired
                    }

                })

                // View user public profile
                .state('app.following', {
                    url: '/user/:id/following',
                    views:{
                        '': {
                            templateUrl: 'app/components/following/following.html',
                            controller: 'FollowingCtrl'
                        },
                        'profileSummary@app.following': {
                            templateUrl: 'app/components/profile/public-profile-summary.html',
                        },
                        'discoverPeople@app.following':{
                            templateUrl: 'app/shared/layouts/people-you-may-know.html',
                        }
                    },
                    resolve: {
                        loginRequired: loginRequired
                    }
                })


                // View user public profile
                .state('app.mentorApply', {
                    url: '/become_a_mentor',
                    views:{
                        '': {
                            templateUrl: 'app/components/mentors/application-mentor.html',
                            controller: 'MentorCtrl',
                        }
                    },
                    resolve: {
                        loginRequired: loginRequired,
                    }

                })

                .state('app.programs', {
                    url: '/learning',
                    templateUrl: 'app/components/programs/programs.html',
                    controller: 'ProgramCtrl',
                    abstract: true
                })

                .state('app.programs.discover', {
                    url: '/discover',
                    views: {
                        '': {
                            templateUrl: 'app/components/programs/discover.program.html',
                            controller: 'DiscoverProgramCtrl',
                            controllerAs: 'discoverProgramVm'
                        }
                    }
                })

                .state('app.createProgram', {
                    url: '/learning/create',
                    views: {
                        '': {
                            templateUrl: 'app/components/programs/create-program.html',
                            controller: 'CreateProgramCtrl',
                            controllerAs: 'createProgramVm'
                        }
                    },
                    resolve: {
                        loginRequired: loginRequired
                    }
                })

                .state('app.programs.me', {
                    url: '/me',
                    views: {
                        '': {
                            templateUrl: 'app/components/programs/my-programs.html',
                            controller: 'CreateProgramCtrl',
                            controllerAs: 'createProgramVm'
                        }
                    },
                    resolve: {
                        loginRequired: loginRequired
                    }
                })

                .state('app.inviteMentors', {
                    url: '/learning/:id/invite/mentors',
                    views:{
                        '': {
                            templateUrl: 'app/components/programs/invite-mentors.html',
                            controller: 'InviteMentorCtrl',
                            controllerAs: 'inviteMentorVm'
                        }
                    },
                    resolve: {
                        loginRequired: loginRequired
                    }
                })

                .state('app.inviteMentees', {
                    url: '/learning/:id/invite/mentees',
                    views: {
                        '': {
                            templateUrl: 'app/components/programs/invite-mentees.html',
                            controller: 'InviteMenteeCtrl',
                            controllerAs: 'inviteMenteeVm'
                        }
                    },
                    resolve: {
                        loginRequired: loginRequired
                    }
                })

                .state('app.program', {
                    url: '/learning/:id',
                    templateUrl: 'app/components/programs/program.html',
                    controller: 'ProgramCtrl',
                    controllerAs: 'programVm',
                    abstract: true
                })

                .state('app.program.home', {
                    url: '/home',
                    views: {
                        '': {
                            templateUrl: 'app/components/programs/program.home.html',
                            controller: 'ProgramHomeCtrl',
                            controllerAs: 'programHomeVm',
                        },
                    },
                })

                .state('app.program.resources', {
                    url: '/resources',
                    views: {
                        '': {
                            templateUrl: 'app/components/programs/program-resources.html',
                            controller: 'ProgramResourceCtrl',
                            controllerAs: 'programResourceVm'
                        }
                    },
                    resolve: {
                        loginRequired: loginRequired
                    }
                })

                .state('app.program.mentors', {
                    url: '/mentors',
                    views: {
                        '': {
                            templateUrl: 'app/components/programs/program-mentors.html',
                            controller: 'ProgramMentorCtrl',
                            controllerAs: 'programMentorVm'
                        }
                    },
                    resolve: {
                        loginRequired: loginRequired
                    }
                })

                .state('app.program.mentees', {
                    url: '/mentees',
                    views: {
                        '': {
                            templateUrl: 'app/components/programs/program-mentees.html',
                            controller: 'ProgramMenteeCtrl',
                            controllerAs: 'programMenteeVm'
                        }
                    },
                    resolve: {
                        loginRequired: loginRequired
                    }
                })

                .state('app.program.tasks', {
                    url: '/tasks',
                    views: {
                        '': {
                            templateUrl: 'app/components/programs/program-task.html',
                            controller: 'ProgramTaskCtrl',
                            controllerAs: 'programTaskVm'
                        }
                    },
                    resolve: {
                        loginRequired: loginRequired
                    }
                })

                .state('app.program.opportunities', {
                    url: '/opportunities',
                    views: {
                        '': {
                            templateUrl: 'app/components/programs/program-opportunities.html',
                            controller: 'ProgramOpportunityCtrl',
                            controllerAs: 'programOpportunityVm',
                        },
                    },
                    resolve: {
                        loginRequired: loginRequired
                    }
                })

                .state('app.profileSettings', {
                    url: '/settings/profile',
                    views:{
                        '': {
                            templateUrl: 'app/components/settings/edit-profile.html',
                            controller: 'SettingsCtrl',
                            controllerAs: 'settingsVm'
                        },
                        'settingsNav@app.profileSettings': {
                            templateUrl: 'app/components/settings/nav-settings.html',
                        }
                    }
                    ,
                    resolve: {
                        loginRequired: loginRequired
                    }
                })

                .state('app.searchResults', {
                    url: '/search?query',
                    views: {
                        '': {
                            templateUrl: 'app/components/search_results/search-results.html',
                            controller: 'SearchResultCtrl',
                            controllerAs: 'searchResultVm'
                        }
                    },
                    resolve: {
                        results: function(searchService, $stateParams) {
                            return searchService.doSearch($stateParams.query)
                        }
                    }
                })

                .state('app.viewInterest', {
                    url: '/interests/:id',
                    views: {
                        '': {
                            templateUrl: 'app/components/interest/interest.html',
                            controller: 'InterestCtrl',
                            controllerAs: 'interestVm'
                        }
                    },
                    resolve: {
                        interestDetails: function(InterestDataOp, $stateParams) {
                            return InterestDataOp.Interest().get({id: $stateParams.id});
                        }
                    }
                });

            $urlRouterProvider.otherwise('/');
        }
    ]);

/***/ }),
/* 3 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


var angular = __webpack_require__(0);
angular.module('app.about', []).controller('AboutCtrl', __webpack_require__(5));

/***/ }),
/* 4 */,
/* 5 */
/***/ (function(module, exports) {

/**
 * Created by jidesakin on 9/9/16.
 */

 function AboutController() {
    var vm = this;
 }



/***/ }),
/* 6 */
/***/ (function(module, exports, __webpack_require__) {

var angular = __webpack_require__(0);

angular.module('app.auth', []).controller('LoginCtrl', __webpack_require__(7))
angular.module('app.auth').controller('ForgotPasswordCtrl', __webpack_require__(8));
angular.module('app.auth').controller('LogoutCtrl', __webpack_require__(9));
angular.module('app.auth').controller('VerifyAccountCtrl', __webpack_require__(10));
angular.module('app.auth').controller('RegisterCtrl', __webpack_require__(11));
angular.module('app.auth').controller('ResetPasswordCtrl', __webpack_require__(12));

/***/ }),
/* 7 */
/***/ (function(module, exports) {

/**
 * Created by jidesakin on 7/3/16.
 */
LoginCtrl.$inject = ['$auth', '$state', '$location', '$rootScope', 'toastr', '$scope', 'UserDataOp']

function LoginCtrl ($auth, $state, $location, $rootScope, toastr, $scope, UserDataOp) {
    var vm = this;
    vm.buttonText = "Login";

    // Login with
    vm.login = function (isValid) {
        vm.buttonText = "Please wait...";

        if (isValid) {
            var credentials = {
                email: vm.email,
                password: vm.password
            };

            // Use satellizer's $auth service to login
            $auth.login(credentials).then(function(response){

                mixpanel.track('Login Successful');

                // Update the root scope variable isAuthenticated to satellizer's isAuthenticated
                $rootScope.isAuthenticated = $auth.isAuthenticated();

                // Get user data from token
                UserDataOp.getPrivateProfile(function(res){

                    // prepare user data to save into local storage
                    var user = JSON.stringify(res);

                    mixpanel.identify(res.email);
                    mixpanel.track('Returning User', {
                        '$first_name': res.first_name,
                        '$last_name': res.last_name,
                        '$email': res.email,
                        '$created': res.created_at,
                        'last_login': (new Date()).toLocaleDateString(),
                        'gender': res.gender,
                        'title': res.headline,
                        'is_a_mentor': res.is_a_mentor
                    });

                    // save user data in the local storage
                    localStorage.setItem('user', user);

                    $rootScope.loggedInUser = res;

                    // Sign in to firebase
                    // firebaseAuthService.login(credentials)
                    //     .then(function(data) {
                    //         console.log(data);
                    //     });

                    toastr.info("Welcome, " + res.first_name);

                    var redirectTo =  localStorage.getItem('prevUrl');

                    if (redirectTo !== null) {
                        $location.path(redirectTo);
                    } else {
                        $location.path('/dashboard');

                    }

                }, function(){
                    toastr.error('Oops! An error occurred');
                    vm.buttonText = "Login";

                });

            }).catch(function(error){

                vm.buttonText = "Login";

                mixpanel.track('Failed Login', {"ErrorCode": error.status});

                switch(error.status){
                    case 401:
                        toastr.warning("Invalid email address or password");
                        break;
                    case 500:
                        toastr.error("Oops! Server Error occurred. We've been notified.");
                        break;
                    default:
                        toastr.error("Oops! An  Error occurred. We've been notified.");
                }

            })
        }
    };

    vm.authenticate = function (provider) {
        $auth.authenticate(provider)
            .then(function(response) {
                toastr.success('You have successfully signed in with ' + provider + '!');
                $location.path('/dashboard');
            })
            .catch(function(error) {
                if (error.error) {
                    toastr.error(error.error);
                } else if (error.data) {
                    toastr.error(error.data.message, error.status);
                } else {
                    toastr.error(error);
                }
            });
    };
}

module.exports = LoginCtrl;

/***/ }),
/* 8 */
/***/ (function(module, exports) {

/**
 * Created by jidesakin on 12/1/16.
 */

ForgotPasswordCtrl.$inject = ['toastr', 'UserDataOp'];
function ForgotPasswordCtrl (toastr, UserDataOp) {
    var vm = this;

        vm.submitForgotPassword = function (isValid) {
            if (isValid) {
                var params = {email: vm.email};
                UserDataOp.confirmPasswordReset(params, function (response) {
                    toastr.success(response.message);
                }, function(error) {
                    toastr.error(error.message);
                });
            }
        };

}

module.exports = ForgotPasswordCtrl;

/***/ }),
/* 9 */
/***/ (function(module, exports) {

/**
 * Created by jidesakin on 7/27/16.
 */

LogoutCtrl.$inject = ['$location', '$auth', 'toastr', '$rootScope'];
function LogoutCtrl ($location, $auth, toastr, $rootScope) {

    if (!$auth.isAuthenticated()) { return; }
    $auth.logout()
        .then(function() {
            $rootScope.isAuthenticated = $auth.isAuthenticated();
            toastr.info("You have been logged out");
            $location.path('/');
        });
}

module.exports = LogoutCtrl;


/***/ }),
/* 10 */
/***/ (function(module, exports) {

/**
 * Created by Jidesakin on 15/03/2017.
 */
VerifyAccountCtrl.$inject = ['$state', '$location', '$auth', '$stateParams', 'UserDataOp', 'toastr'];

function VerifyAccountCtrl ($state, $location, $auth, $stateParams, UserDataOp, toastr) {

    UserDataOp.verifyAccount($stateParams.token, function(res) {
        toastr.success(res.message);
        if (res.user.is_onboarded === 1) {
            $state.go('app.dashboard');
        } else {
            $state.go('gettingStarted.profile');
        }
    }, function (error) {
        toastr.error(error.message);
        $auth.logout();
        $location.path('/login');
    })

}

module.exports = VerifyAccountCtrl;

/***/ }),
/* 11 */
/***/ (function(module, exports) {

/**
 * Created by jidesakin on 7/3/16.
 */
RegisterCtrl.$inject = ['$auth', '$state', '$rootScope', 'toastr', 'UserDataOp'];
function RegisterCtrl($auth, $state, $rootScope, toastr, UserDataOp){

    var vm = this;
    vm.user = {};
    vm.error = {};
    vm.buttonText = "Create Account";

    vm.register = function (isValid) {
        vm.buttonText = "Please wait...";
        if (isValid) {
            var accountData = {};
            if (vm.user.accountType === 'individual') {
                accountData.firstName = vm.user.firstName;
                accountData.lastName = vm.user.lastName;
                accountData.username = vm.user.username;
                accountData.email = vm.user.email;
                accountData.password = vm.user.password;
                accountData.accountType = vm.user.accountType;
            } else {
                accountData.name = vm.user.name;
                accountData.username = vm.user.username;
                accountData.email = vm.user.email;
                accountData.password = vm.user.password;
                accountData.accountType = vm.user.accountType;
            }
            mixpanel.track('Attempted Registration', accountData);
            $auth.signup(accountData)
                .then(function(response) {
                    $auth.setToken(response.data.token);
                    UserDataOp.getPrivateProfile(function(res) {
                            mixpanel.identify(res.email);
                            mixpanel.people.set({
                                '$name': res.name,
                                '$account_type': res.account_type,
                                '$email': res.email,
                                '$created': res.created_at,
                                'last_login': (new Date()).toLocaleDateString(),
                                'gender': res.gender,
                                'title': res.headline,
                                'is_a_mentor': res.is_a_mentor
                            });

                        }, function(res) {
                            mixpanel.track('Error Registration', userData);
                            toastr.error(res.message);
                        }
                    );
                    $state.go('gettingStarted.profile');
                    toastr.info('You account has been created and you are logged in');
                })
                .catch(function(error, status){
                    switch (status) {
                        case 400:
                            mixpanel.track('Failed Registration', userData);
                            toastr.warning(error.message);
                            break;
                        case 500:
                            toastr.error(error.message);
                            mixpanel.track('Server Error', userData);
                            break;
                        default:
                            toastr.error(error.message);
                    }
                });
        }
    };

    vm.socialAuth = function (provider) {
        $auth.authenticate(provider)
            .then(function(response) {
                toastr.success('You have successfully signed in with ' + provider + '!');
                $state.go('gettingStarted.profile');
            })
            .catch(function(error) {
                if (error.error) {
                    toastr.error(error.error);
                } else if (error.data) {
                    toastr.error(error.data.message, error.status);
                } else {
                    toastr.error(error);
                }
            });
    };
}

module.exports = RegisterCtrl;

/***/ }),
/* 12 */
/***/ (function(module, exports) {

/**
 * Created by Jidesakin on 11/02/2017.
 */
ResetPasswordCtrl.$inject = ['UserDataOp', 'toastr', '$stateParams', '$auth', '$rootScope', '$location'];
function ResetPasswordCtrl (UserDataOp, toastr, $stateParams, $auth, $rootScope, $location) {
    var vm = this;
    var token = $stateParams.token;
    UserDataOp.refreshToken({ token: token }, function(response) {
        $auth.setToken(response.token);
    }, function (error) {
        toastr.error('Token expired');
    });

    vm.resetPassword = function () {
        var params = { password: vm.password, password_confirmation: vm.confirmed };
        UserDataOp.resetPassword(params, function (response) {
            console.log(response);
            $auth.logout()
            .then(function() {
            $rootScope.isAuthenticated = $auth.isAuthenticated();
            toastr.info("Your password has been chnanged and have been logged out. Please login with your new password");
            $location.path('/login');
        });
        }, function (error) {
            toastr.error(error.message);
        })
    };
}

module.exports = ResetPasswordCtrl;

/***/ }),
/* 13 */
/***/ (function(module, exports, __webpack_require__) {

angular.module('app.connect', []).controller('ConnectCtrl', __webpack_require__(14));

/***/ }),
/* 14 */
/***/ (function(module, exports) {

/**
 * Created by mayowa on 2/7/16.
 */

 ConnectCtrl.$inject = ['$scope', '$state', '$stateParams', '$http', 'People', 'Follow', 'CONFIG'];
function ConnectCtrl($scope, $state, $stateParams, $http, People, Follow, CONFIG){

    $scope.on_people = true;
    $scope.people = People.get(function() {

    });

    //follow a user
    $scope.follow = function(id){
        return $http.post(CONFIG.API_BSE_URL+'user/follow', {user_id:id})
    };

    // Unfollow a user
    $scope.unfollow = function(id){
        return $http.post(CONFIG.API_BSE_URL+'user/unfollow', {user_id:id})

    };

    // onmouseover followBtn
    $('button.followBtn').live('click', function(e){
        e.preventDefault();

        $button = $(this);

        var id = $button.attr('rel');

        if ($button.hasClass('btn-meetup-inversed')){
            // Do unfollow
            $scope.unfollow(id)
                .success(function(response){

                    if (response.meta.status == 1)
                    {
                        $button.removeClass('btn-following');
                        $button.addClass('btn-meetrabbi');
                        $button.removeClass('btn-meetup-inversed');
                        $button.text('Follow');
                    }
                })
                .error(function(){
                    toastr.error("Oops! Something went wrong!");
                })
        } else {
            // Do follow
            $scope.follow(id)
                .success(function(response){
                    if (response.meta.status == 1){
                        $button.removeClass('btn-meetrabbi');
                        $button.addClass('btn-following');
                        $button.text('Following')
                    }
                })
                .error(function(){
                    toastr.error("Oops! Something went wrong!");
                })
        }
    });

    $scope.hover = function(e) {
        $button = angular.element(e.srcElement);

        if ($button.hasClass('btn-following')) {
            $button.removeClass('btn-following');
            $button.addClass('btn-meetup-inversed'); // unfollow style
            $button.text('Unfollow');
        }

    };

    // onmouseleave: followBtn
    $scope.leave = function(e) {

        $button = angular.element(e.srcElement);

        if ($button.hasClass('btn-meetup-inversed')){
            $button.removeClass('btn-meetup-inversed'); // unfollow
            $button.addClass('btn-following');
            $button.text('Following');
        }
    };

    // view person detail
    $scope.viewProfile = function(id) {
        $state.go('peopleProfile');
    }

}

module.exports = ConnectCtrl;

/***/ }),
/* 15 */
/***/ (function(module, exports, __webpack_require__) {

var angular = __webpack_require__(0);
angular.module('app.dashboard', []).controller('DashboardCtrl', __webpack_require__(16));


/***/ }),
/* 16 */
/***/ (function(module, exports) {

/**
 * Created by jidesakin on 2/6/16.
 */

DashboardCtrl.$inject = ['$scope', '$state', '$stateParams', '$http', 'CONFIG', 'Note', 'toastr', 'UserDataOp', 'MentorDataOp', 'Question', 'Reply'];
function DashboardCtrl($scope, $state, $stateParams, $http, CONFIG, Note, toastr, UserDataOp, MentorDataOp, Question, Reply){
    var vm = this;
    var Mentor = MentorDataOp.mentors();
    $scope.FILE_PATH = CONFIG.FILE_PATH;
    $scope.inviteLoading = false;
    $scope.remoteBucket = CONFIG.REMOTE_AWS_BUCKET;
    vm.defaultCoverPhoto = UserDataOp.defaultCoverPhoto();
    vm.mentors = MentorDataOp.mentors().query();
    vm.selectedMentor = null;
    vm.question = new Question();
    vm.reply = new Reply();
    $scope.invites = [];
    vm.resource = new Note();

    UserDataOp.getPrivateProfile(function(response){
        $scope.user = response;
        mixpanel.track('Opened Dashboard', {
            '$first_name': $scope.user.first_name,
            '$last_name': $scope.user.last_name,
            '$email': $scope.user.email,
            '$created': $scope.user.created_at,
            'last_login': (new Date()).toLocaleDateString(),
            'gender': $scope.user.gender,
            'title': $scope.user.headline,
            'is_a_mentor': $scope.user.is_a_mentor,
            'account_type': $scope.user.account_type
        });
        var now = new Date();
        vm.accountCreatedSince = Math.floor(( now - Date.parse($scope.user.created_at)) / 86400000);
    }, function(){});

    UserDataOp.discoverPeople().get().$promise.then(function(response){
        $scope.people = response.data.people;
    });

    $scope.showArticle = function(){
        $state.go('article');
    };

    $scope.pwdIsSet = true;
    var checkIfPwdIsSet = function () {
        $http.get(CONFIG.API_BSE_URL + 'user/password/check')
            .success(function(response){
                $scope.pwdIsSet = response.data.pwd_isset;
            })
    };

    $scope.featuredMentors = Mentor.query();
    vm.resources = Note.query();

    checkIfPwdIsSet();

    var getQuestions = function () {
        vm.questions = Question.query({ pageType: 'dashboard' });
    };
        
    /**
     * @name showQuestion
     * @param {Integer} id 
     */
    vm.showQuestion = function (id) {
        Question.get({id: id}, function(response) {
            vm.questionDetails = response;
            $('#questionModal').modal({show: true});
        });
    };

    getQuestions();

    // Send invitation to email addresses
    $scope.invite = function() {
        var invitesData =  {};
        invitesData.emails = [];
        $scope.invites.forEach(function(email){
            invitesData.emails.push(email.text);
        });
        mixpanel.track('Sent Invite', invitesData);

        $http.post(CONFIG.API_BSE_URL + 'invites', invitesData)
            .success(function(response){
                if (response.meta.status == 1) {
                    $scope.invites = [];
                    toastr.success("Invitation has been sent.");
                }
            })
            .catch(function(){
                toastr.error("Oops! Something went wrong");
            })
    };
    
    
    // Set the password 
    $scope.setPassword = function() {
        var params = {password : $scope.password};
        $http.post(CONFIG.API_BSE_URL + 'user/password/set', params)
            .success(function(){
                toastr.success("Your account is now secured.");
                $scope.pwdIsSet = true;
            })
            .error(function () {
                toastr.error("Oops! Something went wrong. Please try again.");
            })
    };

        /**
     * @name postQuestion
     * @return void
     */
    vm.postQuestion = function () {
        vm.question.directedTo = vm.selectedMentor.id;
        vm.question.$save()
        .then(function(response) {
            mixpanel.track('Post Question', vm.question);

            if (response){
                toastr.success("Your question has been submitted");
                getQuestions();
            }
        })
        .catch(function(error) {
            toastr.error("Oops an error occurred");
        });
    };

    /**
     * @name postReply
     * @param {Integer} questionId
     */
    vm.postReply = function (questionId) {
        vm.reply.questionId = questionId;
        mixpanel.track('Post Reply', vm.reply);

        vm.reply.$save()
        .then(function(response) {
            vm.reply = new Reply();
            Question.get({id: questionId}, function(response) {
                vm.questionDetails = response;
            });
            toastr.success("Your reply has been submitted");
        })
        .catch(function() {
            toastr.error("Oops an error occurred");
        });
    };

    vm.nominateMentor = function() {
        var params = { 
            nomineeEmail: vm.nomineeEmail,
            nomineeNote: vm.nomineeNote
        };
        mixpanel.track('Nominate Mentor', params);

        $http.post(CONFIG.API_BSE_URL + 'mentor/nominate', params)
            .success(function(){
                toastr.success("Thank you. Your nominee has been contacted!");
            })
            .error(function () {
                toastr.error("Oops! Something went wrong. Please try again.");
            });
    };

    /**
     * @name showQuestion
     * @param {Integer} id 
     */
    vm.showKnowledgeSharingModal = function () {
        mixpanel.track('Attempt to Share Knowledge', {});
        $('#shareKnowledgeModal').modal({show: true});
    };


    vm.shareResource = function() {
        mixpanel.track('Shared Resource', vm.resource);
        vm.resource.$save()
        .then(function(response){
            if (response.meta.status == 1) {
                toastr.success("Your knowledge has been shared");
                vm.resources = Note.query();            }
        })
        .catch(function(){
            toastr.error("Oops an error occurred");
        });
    };

    vm.upvote = function(postId) {
        swal({
            title: 'Coming soon',
            text: 'You will be notified as soon as we launch this feature',
            timer: 2000,
            type: 'info',
        })
    };


}

module.exports = DashboardCtrl;

/***/ }),
/* 17 */
/***/ (function(module, exports, __webpack_require__) {

var angular = __webpack_require__(0);
angular.module('app.followers', []).controller('FollowerCtrl', __webpack_require__(18));

/***/ }),
/* 18 */
/***/ (function(module, exports) {

/**
 * Created by mayowa on 2/7/16.
 */
FollowerCtrl.$inject = ['$scope', '$state', '$location', '$stateParams', '$http', 'CONFIG', 'toastr', 'UserDataOp']
function FollowerCtrl($scope, $state, $location, $stateParams, $http, CONFIG, toastr, UserDataOp){
    $scope.FILE_PATH = CONFIG.FILE_PATH;
    $scope.defaultCoverPhoto = UserDataOp.defaultCoverPhoto();
    UserDataOp.getPublicProfile($stateParams.id, function(response){

        $scope.user = response;

    }, function(error){

    });

    UserDataOp.getFollowers().get({id: $stateParams.id})
    .$promise.then(function(response){
        $scope.followers = response.data.followers;
    });

    $scope.concatExpertise = function(expertise) {
        var expertiseNames = expertise.map(function(item) {
            return item.name;
        });
        return expertiseNames.join(', ');
    };

    UserDataOp.discoverPeople().get().$promise.then(function(response){
        $scope.people = response.data.people;
    });

    $scope.unFollow = function(id, $button) {

        UserDataOp.unfollow(id, function(response){
            if (response.meta.status == 1) {
                $button.removeClass('btn-unfollow');
                $button.addClass('btn-follow');
                $button.text('Follow');
            }

        }, function(){
            toastr.error("Oops! Something went wrong!");

        });
    };

    //follow a user
    $scope.follow = function(id, $button){

        UserDataOp.follow(id, function(response){

            if (response.meta.status == 1){
                $button.removeClass('btn-follow');
                $button.addClass('btn-following');
                $button.text('Following');
            }

        }, function(){
            toastr.error("Oops! Something went wrong!");
        });

    };

    // onmouseover followBtn
    $('button.followBtn').live('click', function(e){
        e.preventDefault();

        $button = $(this);

        var id = $button.attr('rel');

        if ($button.hasClass('btn-unfollow')){
            // Do unfollow
            $scope.unFollow(id, $button);

        } else {
            // Do follow
            $scope.follow(id, $button);
        }
    });

    $scope.hover = function(e) {
        $button = angular.element(e.srcElement);

        if ($button.hasClass('btn-following')) {
            $button.removeClass('btn-following');
            $button.addClass('btn-unfollow'); // unfollow style
            $button.text('Unfollow');
        }

    };

    // onmouseleave: followBtn
    $scope.leave = function(e){

        $button = angular.element(e.srcElement);

        if ($button.hasClass('btn-unfollow')){
            $button.removeClass('btn-unfollow'); // unfollow
            $button.addClass('btn-following');
            $button.text('Following');
        }
    };

}

module.exports = FollowerCtrl;

/***/ }),
/* 19 */
/***/ (function(module, exports, __webpack_require__) {

var angular = __webpack_require__(0);
angular.module('app.following', []).controller('FollowingCtrl', __webpack_require__(20));

/***/ }),
/* 20 */
/***/ (function(module, exports) {

/**
 * Created by mayowa on 2/7/16.
 */
FollowingCtrl.$inject = ['$scope', '$state', '$location', '$stateParams', '$http', 'CONFIG', 'toastr', 'UserDataOp']
function FollowingCtrl($scope, $state, $location, $stateParams, $http, CONFIG, toastr, UserDataOp){

    $scope.FILE_PATH = CONFIG.FILE_PATH;
    
    $scope.remoteBucket = CONFIG.REMOTE_AWS_BUCKET;
    $scope.defaultCoverPhoto = UserDataOp.defaultCoverPhoto();
    UserDataOp.getPublicProfile($stateParams.id, function(response){
        $scope.user = response;
    }, function(error){
        toastr.error("Oops! Something went wrong!");
    });
    
    UserDataOp.getFollowing().get({id: $stateParams.id}).$promise.then(function(response){
        $scope.following = response.data.following;
    });

    UserDataOp.discoverPeople().get().$promise.then(function(response){
        $scope.people = response.data.people;
    });

    $scope.unFollow = function(id, $button) {

        UserDataOp.unfollow(id, function(response){
            if (response.meta.status == 1) {
                $button.removeClass('btn-unfollow');
                $button.addClass('btn-follow');
                $button.text('Follow');
                $state.reload();
            }

        }, function(){
            toastr.error("Oops! Something went wrong!");

        });
    };

    $scope.concatExpertise = function(expertise) {
        var expertiseNames = expertise.map(function(item) {
            return item.name;
        });
        return expertiseNames.join(', ');
    };

    //follow a user
    $scope.follow = function(id, $button) {

        UserDataOp.follow(id, function(response){

            if (response.meta.status == 1){
                $button.removeClass('btn-follow');
                $button.addClass('btn-following');
                $button.text('Following');

                $state.reload();
            }
        }, function(){
            toastr.error("Oops! Something went wrong!");
        });

    };

    // onmouseover followBtn
    $('button.followBtn').live('click', function(e){
        e.preventDefault();

        $button = $(this);

        var id = $button.attr('rel');

        if ($button.hasClass('btn-unfollow')){
            // Do unfollow
            $scope.unFollow(id, $button);
            console.log($button);

        } else {
            // Do follow
            $scope.follow(id, $button);
            console.log($button);

        }
    });

    $scope.hover = function(e) {
        $button = angular.element(e.srcElement);

        if ($button.hasClass('btn-following')) {
            $button.removeClass('btn-following');
            $button.addClass('btn-unfollow'); // unfollow style
            $button.text('Unfollow');
        }

    };

    // onmouseleave: followBtn
    $scope.leave = function(e){

        $button = angular.element(e.srcElement);

        if ($button.hasClass('btn-unfollow')){
            $button.removeClass('btn-unfollow'); // unfollow
            $button.addClass('btn-following');
            $button.text('Following');
        }
    };


}

module.exports = FollowingCtrl;

/***/ }),
/* 21 */
/***/ (function(module, exports, __webpack_require__) {

var angular = __webpack_require__(0);
angular.module('app.gettingStarted', []).controller('GettingStartedCtrl', __webpack_require__(22));

/***/ }),
/* 22 */
/***/ (function(module, exports) {

/**
 * Created by jidesakin on 2/6/16.
 */

GettingStartedCtrl.$inject = ['$scope', '$state', '$window', '$stateParams', '$http', '$rootScope', '$location', 'toastr', 'CONFIG', 'UserDataOp'];
function GettingStartedCtrl($scope, $state, $window, $stateParams, $http, $rootScope, $location, toastr, CONFIG, UserDataOp){

    var vm = this;

    $scope.user = {};
    $scope.user.interests = [];
    var Interest = UserDataOp.Interest();
    $scope.FILE_PATH = CONFIG.FILE_PATH;
    $scope.mentors = [];
    $scope.invites = [];

    $scope.availableAreasOfInterest = Interest.query();

    // Get user profile
    UserDataOp.getPrivateProfile(function(response){
        $scope.user = response;
    }, function(){
        toastr.error('An error occurred, please check your connection');
    });

    // update basic profile details
    vm.updateBasicProfile = function (isValid) {
        UserDataOp.updateBasicProfile($scope.user, function (response){
            toastr.success(response.message);
            $state.go('gettingStarted.interests');
        }, function (error) {
            toastr.error(error.message);
        });
    };

    // Update user interests
    vm.updateInterests = function () {
        UserDataOp.updateInterests($scope.user, function (response){
            toastr.success(response.message);
            UserDataOp.getMatchedMentors(function(response){
                $scope.mentors = response;
                $state.go('gettingStarted.connect');
            }, function(){
                toastr.error('An error occurred, please check your connection');
            });
        }, function (error) {
            toastr.error(error.message);
        });
    };

    //follow a user
    $scope.follow = function(id){
        return $http.post(CONFIG.API_BSE_URL+'user/follow', {user_id:id})
    };

    // Unfollow a user
    $scope.unfollow = function(id){
        return $http.post(CONFIG.API_BSE_URL+'user/unfollow', {user_id:id})
    };

    // onmouseover followBtn
    $('button.followBtn').live('click', function(e){
        e.preventDefault();

        $button = $(this);

        var id = $button.attr('rel');

        if ($button.hasClass('btn-unfollow')){
            // Do unfollow
            $scope.unfollow(id)
                .success(function(response){

                    if (response.meta.status == 1) {
                        $button.removeClass('btn-unfollow');
                        $button.addClass('btn-follow');
                        $button.text('Follow');
                    }
                })
                .error(function(){
                    toastr.error("Oops! Something went wrong!");
                })

        } else {
            // Do follow
            $scope.follow(id)
                .success(function(response){

                    if (response.meta.status == 1){
                        $button.removeClass('btn-follow');
                        $button.addClass('btn-following');
                        $button.text('Following')
                    }

                })
                .error(function(){
                    toastr.error("Oops! Something went wrong!");
                })
        }
    });

    $scope.hover = function(e) {
        $button = angular.element(e.srcElement);

        if ($button.hasClass('btn-following')) {
            $button.removeClass('btn-following');
            $button.addClass('btn-unfollow'); // unfollow style
            $button.text('Unfollow');
        }

    };

    // onmouseleave: followBtn
    $scope.leave = function(e){

        $button = angular.element(e.srcElement);

        if ($button.hasClass('btn-unfollow')){
            $button.removeClass('btn-unfollow'); // unfollow
            $button.addClass('btn-following');
            $button.text('Following');
        }
    };

    // Send invitation to email addresses
    vm.invite = function() {
        var invitesData =  {};
        invitesData.emails = [];
        $scope.invites.forEach(function(email){
            invitesData.emails.push(email.text);
        });
        $http.post(CONFIG.API_BSE_URL + 'invites', invitesData)

            .success(function(response){
                if (response.meta.status == 1)
                {
                    $scope.invites = [];
                    toastr.success("Invitation has been sent.");
                }
            })
            .catch(function(){
                toastr.error("Oops! Something went wrong");
            })
    };

}

module.exports = GettingStartedCtrl;

/***/ }),
/* 23 */
/***/ (function(module, exports, __webpack_require__) {

var angular = __webpack_require__(0);
angular.module('app.home', []).controller('HomeCtrl', __webpack_require__(24));

/***/ }),
/* 24 */
/***/ (function(module, exports) {

/**
 * Created by Jidesakin on 19/12/2016.
 */

HomeCtrl.$inject = ['$auth', '$scope', '$state', 'MentorDataOp', 'Question', 'Note', 'ResourceDataOp', 'MiscDataOp'];
function HomeCtrl ($auth, $scope, $state, MentorDataOp, Question, Note, ResourceDataOp, MiscDataOp) {
    var vm = this;
    vm.featuredMentors = MentorDataOp.FeaturedMentors().query();
    $scope.isAuthenticated = $auth.isAuthenticated();
    vm.resources = ResourceDataOp.TopResource().query();
    vm.questions = MiscDataOp.PublicQuestions().query();

    vm.search = function () {
        $state.go('app.searchResults', {query: vm.interest});
    }
        
}
module.exports = HomeCtrl;

/***/ }),
/* 25 */
/***/ (function(module, exports, __webpack_require__) {

var angular = __webpack_require__(0)
angular.module('app.interest', []).controller('InterestCtrl', __webpack_require__(26));

/***/ }),
/* 26 */
/***/ (function(module, exports) {

/**
 * Created by Jidesakin on 13/06/2017.
 */
InterestCtrl.$inject = ['$state', 'interestDetails'];

function InterestCtrl ($state, interestDetails) {

    var vm = this;

    vm.interestDetails = interestDetails;
}
module.exports = InterestCtrl;

/***/ }),
/* 27 */
/***/ (function(module, exports, __webpack_require__) {

var angular = __webpack_require__(0);
angular.module('app.mentors', []) .controller('MentorCtrl', __webpack_require__(28));

/***/ }),
/* 28 */
/***/ (function(module, exports) {

/**
 * Created by jidesakin on 7/17/16.
 */
MentorCtrl.$inject = ['$scope', '$state', '$stateParams', '$http', 'CONFIG', 'toastr', '$location', 'MentorDataOp', 'MenteeDataOp', 'UserDataOp']
function MentorCtrl($scope, $state, $stateParams, $http, CONFIG, toastr, $location, MentorDataOp, MenteeDataOp, UserDataOp){
    var vm = this;
    $scope.FILE_PATH = CONFIG.FILE_PATH;
    var Specialization = MentorDataOp.Specialization();
    var Mentor = MentorDataOp.mentors();
    var Mentee = MenteeDataOp.mentees();
    var MentorYouFollow = MentorDataOp.MentorYouFollow();
    var MentoringApplication = MentorDataOp.MentoringApplication();

    $scope.mentorApplication = new MentoringApplication();
    $scope.featuredMentors = Mentor.query();
    $scope.mentees = Mentee.query();
    $scope.mentorApplication.expertise = [];
    vm.mentorsYouFollow = MentorYouFollow.query();
    vm.defaultCoverPhoto = UserDataOp.defaultCoverPhoto();
    vm.defaultMenteeCoverPhoto = UserDataOp.defaultMenteeCoverPhoto();

    $scope.formData = {};
    mixpanel.track('Discover People', {
    });

    // Get user profile
    UserDataOp.getPrivateProfile(function(response){
        $scope.user = response;
    }, function(){});

    Specialization.query(function(response){
        $scope.availableSpecializations = response;
    });

    // Submit mentor application
    $scope.submitApplication = function(){
        mixpanel.track('Attempt Mentor Application', $scope.mentorApplication);
        if ($scope.mentorApplication.expertise.length) {
            $scope.mentorApplication.$save()
                .then(function(response){
                    mixpanel.track('Successful Mentor Application', $scope.mentorApplication);
                    toastr.success(response.message);
                })
                .catch(function(){
                    mixpanel.track('Failed Mentor Application', $scope.mentorApplication);
                });
        } else {
            toastr.warning("Please fill the required fields.");
        }
    };

    $scope.concatExpertise = function(expertise) {
        var expertiseNames = expertise.map(function(item) {
            return item.name;
        });
        return expertiseNames.join(', ');
    };

}

module.exports = MentorCtrl;

/***/ }),
/* 29 */
/***/ (function(module, exports, __webpack_require__) {

var angular = __webpack_require__(0);
angular.module('app.notes', []).controller('NoteCtrl', __webpack_require__(30));
angular.module('app.notes').controller('EditNoteCtrl', __webpack_require__(31));
angular.module('app.notes').controller('CreateNoteCtrl', __webpack_require__(32));
angular.module('app.notes').controller('ViewNoteCtrl', __webpack_require__(33));

/***/ }),
/* 30 */
/***/ (function(module, exports) {

/**
 * Created by jidesakin on 2/13/16.
 */

NoteCtrl.$inject = ['$scope', '$http', '$state', '$stateParams', 'Note', 'CONFIG', 'UserDataOp'];
function NoteCtrl($scope, $http, $state, $stateParams, Note, CONFIG, UserDataOp){

    $scope.remoteBucket = CONFIG.REMOTE_AWS_BUCKET;

    $scope.FILE_PATH = CONFIG.FILE_PATH;

    // Get user profile
    UserDataOp.getPrivateProfile(function(response){

        $scope.user = response;

    }, function(){

    });


    // Get notes by the authenticated user
    $scope.getNotes = function() {
        $http.get(CONFIG.API_BSE_URL+'me/resources')
            .success(function(response){
                $scope.resources = response.data.resources;
            });
    };

    // get resources
    $scope.getNotes();

}

module.exports = NoteCtrl;



/***/ }),
/* 31 */
/***/ (function(module, exports) {

/**
 * Created by jidesakin on 12/6/16.
 */
EditNoteCtrl.$inject = ['$scope', '$http', '$state', '$stateParams', 'Note', 'CONFIG', 'toastr', 'UserDataOp'];
function EditNoteCtrl($scope, $http, $state, $stateParams, Note, CONFIG, toastr, UserDataOp) {


    $scope.remoteBucket = CONFIG.REMOTE_AWS_BUCKET;

    // Get user profile
    UserDataOp.getPrivateProfile(function(response){
        $scope.user = response;
    }, function(){
        // Do nothing
    });


    Note.get({id: $stateParams.id}).$promise.then(function(response){
        $scope.resource = response.data.resource;
        $scope.mentoringArea = {id: $scope.resource.mentoring_area_id, name: $scope.resource.mentoring_area};
    });

    $scope.sizeLimit      = 10585760; // 10MB in Bytes
    $scope.uploadProgress = 0;

    // Amazon credentials
    $scope.creds = {
        bucket: 'meetrabbi',
        access_key: 'AKIAJEXMDZOVXOJXSNXA',
        secret_key: '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'
    };

    $scope.upload = function() {

        // Configure The S3 Object
        AWS.config.update({ accessKeyId: $scope.creds.access_key, secretAccessKey: $scope.creds.secret_key });
        AWS.config.region = 'us-east-1';
        var bucket = new AWS.S3({ params: { Bucket: $scope.creds.bucket } });

        if($scope.file) {

            var fileSize = Math.round(parseInt($scope.file.size));
            if (fileSize > $scope.sizeLimit) {
                toastr.error('Sorry, your attachment is too big. <br/> Maximum '  + $scope.fileSizeLabel() + ' file attachment allowed','File Too Large');
                return false;
            }

            // Prepend Unique String To Prevent Overwrites
            var uniqueFileName = $scope.uniqueString() + '-' + $scope.file.name;

            $scope.remoteFileName = uniqueFileName;

            var params = { Key: uniqueFileName, ContentType: $scope.file.type, Body: $scope.file, ServerSideEncryption: 'AES256' };

            bucket.putObject(params, function(err, data) {

                if(err) {
                    // There Was An Error With Your S3 Config
                    $scope.loading = false;

                    toastr.error(err.message,err.code);
                    return false;
                } else {

                    $scope.resource.featured_image_uri = uniqueFileName;

                    toastr.success('Upload Successfully');
                }
            })
                .on('httpUploadProgress',function(progress) {
                    // Log Progress Information
                    $scope.uploadProgress = Math.round(progress.loaded / progress.total * 100);
                    $scope.$digest();
                });
        } else {
            $scope.loading = false;

            // No File Selected
            toastr.error('Please select a file to upload');
        }
    };

    $scope.fileSizeLabel = function() {
        // Convert Bytes To MB
        return Math.round($scope.sizeLimit / 1024 / 1024) + 'MB';
    };


    $scope.uniqueString = function() {
        var text     = "";
        var possible = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";

        for (var i=0; i < 8; i++) {
            text += possible.charAt(Math.floor(Math.random() * possible.length));
        }
        return text;
    };

    var getExpertise = function() {
        $http.get(CONFIG.API_BSE_URL + 'user/expertise')
            .success(function(response){
                $scope.mentoringAreas = response.data.expertise;
            });
    };


    $scope.updateResource = function() {
        $scope.resource.mentoring_area_id = $scope.mentoringArea.id;
        $http.post(CONFIG.API_BSE_URL + 'resources/' + $stateParams.id + '/update', $scope.resource)
            .success(function(){
                toastr.success("Note has been updated");
                $state.go('app.myNotes');
            });
    };


    //
    getExpertise();

}

module.exports = EditNoteCtrl;

/***/ }),
/* 32 */
/***/ (function(module, exports) {

/**
 * Created by jidesakin on 2/17/16.
 */
CreateNoteCtrl.$inject = ['$scope', '$http', '$state', '$stateParams', 'Note', 'toastr', '$window', 'CONFIG', 'UserDataOp']
function CreateNoteCtrl($scope, $http, $state, $stateParams, Note, toastr, $window, CONFIG, UserDataOp){

    $scope.remoteFileName = null;

    // Get user profile
    UserDataOp.getPrivateProfile(function(response){
        $scope.user = response;
    }, function(){
        // do nothing
    });


    // Create a new resource
    $scope.resource = new Note();

    var getExpertise = function() {
        $http.get(CONFIG.API_BSE_URL + 'user/expertise')
            .success(function(response){
                $scope.mentoringAreas = response.data.expertise;
            });
    };


    // Publish a new resource
    $scope.publishResource = function() {

        $scope.resource.featured_image_uri = $scope.remoteFileName;
        $scope.resource.interest_id = $scope.mentoringArea.id;

        $scope.resource.$save()
            .then(function(response){

                if (response.meta.status == 1){

                    toastr.success("Your resource has been published");
                    $state.go('app.myNotes');
                }

            })
            .catch(function(){
                toastr.error("Oops an error occurred");
            })
    };


    $scope.sizeLimit = 10585760; // 10MB in Bytes
    $scope.uploadProgress = 0;

    // Amazon credentials
    $scope.creds = {
        bucket: 'meetrabbi',
        access_key: 'AKIAJEXMDZOVXOJXSNXA',
        secret_key: '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'
    };

    // Upload file
    $scope.upload = function() {
        // Configure The S3 Object
        AWS.config.update({ accessKeyId: $scope.creds.access_key, secretAccessKey: $scope.creds.secret_key });
        AWS.config.region = 'us-east-1';
        var bucket = new AWS.S3({ params: { Bucket: $scope.creds.bucket } });

        if ($scope.file) {

            var fileSize = Math.round(parseInt($scope.file.size));
            if (fileSize > $scope.sizeLimit) {
                toastr.error('Sorry, your attachment is too big. <br/> Maximum '  + $scope.fileSizeLabel() + ' file attachment allowed','File Too Large');
                return false;
            }

            // Prepend Unique String To Prevent Overwrites
            var uniqueFileName = $scope.uniqueString() + '-' + $scope.file.name;

            $scope.remoteFileName = uniqueFileName;

            var params = { Key: uniqueFileName, ContentType: $scope.file.type, Body: $scope.file, ServerSideEncryption: 'AES256' };

            bucket.putObject(params, function(err, data) {

                    if (err) {
                        // There Was An Error With Your S3 Config
                        toastr.error(err.message,err.code);
                        return false;
                    } else {
                        // Success!
                        toastr.success('Upload Successfully');
                    }
                })
                .on('httpUploadProgress',function(progress) {
                    // Log Progress Information
                    $scope.uploadProgress = Math.round(progress.loaded / progress.total * 100);
                    $scope.$digest();
                });
        } else {
            // No File Selected
            toastr.error('Please select a file to upload');
        }
    };

    $scope.fileSizeLabel = function() {
        // Convert Bytes To MB
        return Math.round($scope.sizeLimit / 1024 / 1024) + 'MB';
    };

    $scope.uniqueString = function() {
        var text     = "";
        var possible = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";

        for (var i = 0; i < 8; i++ ) {
            text += possible.charAt(Math.floor(Math.random() * possible.length));
        }
        return text;
    };


    getExpertise();


}

module.exports = CreateNoteCtrl;

/***/ }),
/* 33 */
/***/ (function(module, exports) {

/**
 * Created by jidesakin on 12/6/16.
 */

ViewNoteCtrl.$inject = ['$scope', '$state', '$stateParams', '$http', 'CONFIG', 'Note', '$location', 'toastr', '$mdSidenav'];
function ViewNoteCtrl($scope, $state, $stateParams, $http, CONFIG, Note, $location, toastr, $mdSidenav) {

    $scope.remoteBucket = CONFIG.REMOTE_AWS_BUCKET;
    $scope.shareModal = false;
    $scope.currentUrl = $location.path();
    $scope.comment = {};

    var vm = this;

    viewNote();
    getComments();
    getQuestions();
    getVotes();

    // get a resource from storage
    function viewNote() {
        // increment views
        Note.get({id: $stateParams.id}).$promise.then(function(response){
            $scope.resource = response.data.resource;
            $scope.relatedResources = response.data.related_resources;
        });
    }

    // get all the comments for a resource
    function getComments() {
        $http.get(CONFIG.API_BSE_URL+'resources/' + $stateParams.id + '/comments')
            .success(function(response){
                $scope.comments = response.data.comments;
            });
    }

    //  Get all questions for a particular resource
    function getQuestions() {
        $http
            .get(CONFIG.API_BSE_URL + 'resources/ '+ $stateParams.id + '/questions')
            .success(function(response) {
                $scope.questions = response.data.questions;
            });
    }

    // Get all the votes
    function getVotes(){
        $http.get(CONFIG.API_BSE_URL + 'resources/' + $stateParams.id + '/votes')
            .success(function(response){
                // $scope.votes = response.data.upvotes;
            });
    }

    // post a comment
    $scope.submitComment = function() {
        var comment = {};

        comment.content = $scope.comment.content.trim();
        comment.resource_id = $stateParams.id;

        $scope.comment.content = '';
        $http.post(CONFIG.API_BSE_URL+'comments', comment)
            .success(function(){
                getComments();

            }).error(function(){

        })
    };

    // Post a question
    $scope.submitQuestion = function(){

        var question = {};
        question.content = $scope.question.content.trim();
        question.resource_id = $stateParams.id;

        $scope.question.content = '';

        $http.post(CONFIG.API_BSE_URL+'questions', question)
            .success(function(response){

                if (response.meta.status == 1) {
                    getQuestions();
                } else {

                }
            })
            .error(function(){

            })
    };

    // Upvote note
    $scope.upVote = function(){
        var vote = {};

        $http.post(CONFIG.API_BSE_URL+'resources/'+$stateParams.id+'/upvote', vote)
            .success(function(response){
                if (response.meta.status == 1) {
                    toastr.success("You have upvoted this note");
                    $scope.viewNote();
                }
            })
            .catch(function() {

                toastr.error("Oops! Something went wrong!");
            })
    };

    // Upvote comment
    $scope.upVoteComment = function(commentId){

        $http.post(CONFIG.API_BSE_URL + 'comments/' + commentId + '/upvote')
            .success(function(response){
                if (response.meta.status == 1) {
                    getComments();
                }
            })
            .catch(function(error){
                toastr.error("Oops! Something went wrong!");
            });
    };

    // Upvote question
    $scope.upVoteQuestion = function(questionId){

        $http.post(CONFIG.API_BSE_URL + 'questions/' + questionId + '/upvote')
            .success(function(response){
                if (response.meta.status == 1) {
                    getQuestions();
                }
            })
            .catch(function(){
                toastr.error("Oops! Something went wrong!");
            })
    };


    // Show delete attribute modal
    $scope.showShareModal = function(){
        $scope.shareModal = !$scope.shareModal;
    };

    vm.showUpVotes = function () {
        // var votes = [{name: "jide", avatar_uri: "assets/img/avatar.png"}, {name: "Taiwo", avatar_uri: "assets/img/avatar.png"}];
        // swal({
        //     title: 'People who upvoted this!',
        //     text: 'Do you want to continue',
        //     type: 'info',
        //     confirmButtonText: 'Close',
        //     html: buildUpvotes(votes)
        // });
    };

    function buildUpvotes(votes) {
        var html = "";
        votes.forEach(function(elem) {
            html = html +
                '<div class="row comment">' +
                    '<div class="media media-v2">' +
                        '<a class="">' +
                            '<img src="'+ elem.avatar_uri + '" class="media-object rounded-x" alt="Profile Picture" style="width: 35px">' +
                        '</a>' +
                        '<div class="media-body">' +
                            '<h4 class="media-heading">' +
                                '<strong>' +
                                    elem.name +
                                '</strong>' +
                            '</h4>' +
                        '</div>'+
                    '</div>'+
                '</div>'
        });
        return html
    }

    vm.showReads = function () {

        // swal.setDefaults({
        //     input: 'text',
        //     confirmButtonText: 'Next &rarr;',
        //     showCancelButton: true,
        //     animation: false,
        //     progressSteps: ['1', '2', '3']
        // });
        //
        // var steps = [
        //     {
        //         title: 'Question 1',
        //         text: 'Chaining swal2 modals is easy'
        //     },
        //     'Question 2',
        //     'Question 3'
        // ]
        //
        // swal.queue(steps).then(function (result) {
        //     swal.resetDefaults()
        //     swal({
        //         title: 'All done!',
        //         html:
        //         'Your answers: <pre>' +
        //         JSON.stringify(result) +
        //         '</pre>',
        //         confirmButtonText: 'Lovely!',
        //         showCancelButton: false
        //     })
        // }, function () {
        //     swal.resetDefaults()
        // });


    };
}

module.exports = ViewNoteCtrl;

/***/ }),
/* 34 */
/***/ (function(module, exports, __webpack_require__) {

var angular = __webpack_require__(0);
angular.module('app.profile', []).controller('PublicProfileCtrl', __webpack_require__(35));
angular.module('app.profile').controller('PrivateProfileCtrl', __webpack_require__(36));


/***/ }),
/* 35 */
/***/ (function(module, exports) {

/**
 * Created by jidesakin on 12/6/16.
 */
PublicProfileCtrl.$inject = ['$scope', '$state', '$stateParams', '$http', '$location', 'CONFIG', 'UserDataOp', 'toastr', 'Question', 'Reply'];
function PublicProfileCtrl($scope, $state, $stateParams, $http, $location, CONFIG, UserDataOp, toastr, Question, Reply) {

    var vm = this;
    $scope.remoteBucket = CONFIG.REMOTE_AWS_BUCKET;
    $scope.currentUrl = $location.absUrl();
    $scope.userId = $stateParams.id;
    vm.getPublicProfile = getProfile();
    vm.question = new Question();
    vm.reply = new Reply();

    function getProfile () {
        UserDataOp.getPublicProfile($stateParams.id, function(response) {
            if (response.cover_photo_url == null || response.cover_photo_url == '') {
                vm.coverPhoto = UserDataOp.defaultCoverPhoto();
            } else {
                vm.coverPhoto = { "background-image": 'url(' + response.cover_photo_url + ')' };
            }
            $scope.user = response;
            $scope.user.initials = response.first_name.charAt().toUpperCase() + response.last_name.charAt().toUpperCase() +"";
            console.log(typeof $scope.user.initials);

        }, function(error){
            toastr.error('An error occurred');

        });
    }

    // Onclick followBtn
    $('button.followBtn').live('click', function(e){
        e.preventDefault();
        $button = $(this);
        var id = $button.attr('rel');
        if ($button.hasClass('btn-meetup-inversed')){
            UserDataOp.unfollow(id, function(response){
                if (response.meta.status == 1) {
                    $button.removeClass('btn-following');
                    $button.addClass('btn-meetrabbi');
                    $button.removeClass('btn-meetup-inversed');
                    $button.text('Follow');
                }
            }, function(){
                toastr.error("Oops! Something went wrong!");
            });
        } else {
            UserDataOp.follow(id, function(response){
                if (response.meta.status == 1){
                    $button.removeClass('btn-meetrabbi');
                    $button.addClass('btn-following');
                    $button.text('Following')
                }
            }, function(){
                toastr.error("Oops! Something went wrong!");
            });
        }
    });

    // Onmousehover: follow button
    $scope.hover = function(e) {
        $button = angular.element(e.srcElement);
        if ($button.hasClass('btn-following')) {
            $button.removeClass('btn-following');
            $button.addClass('btn-meetup-inversed'); // unfollow style
            $button.text('Unfollow');
        }
    };

    // onmouseleave: followBtn
    $scope.leave = function(e){
        $button = angular.element(e.srcElement);
        if ($button.hasClass('btn-meetup-inversed')){
            $button.removeClass('btn-meetup-inversed'); // unfollow
            $button.addClass('btn-following');
            $button.text('Following');
        }
    };

    function getQuestions() {
        vm.questions = Question.query({ profileType: 'public', directedTo: $scope.userId});
    }

    /**
     * @name postQuestion
     * @return void
     */
    vm.postQuestion = function () {
        vm.question.directedTo = $scope.userId;
        vm.question.$save()
        .then(function(response) {
            if (response){
                toastr.success("Your question has been submitted");
                getQuestions();
            }
        })
        .catch(function(error) {
            toastr.error("Oops an error occurred");
        });
    };

    /**
     * @name showQuestion
     * @param {Integer} id 
     */
    vm.showQuestion = function (id) {
        Question.get({id: id}, function(response) {
            vm.questionDetails = response;
            $('#questionModal').modal({show: true});
        });
    };

    /**
     * @name postReply
     * @param {Integer} questionId
     */
    vm.postReply = function (questionId) {
        vm.reply.questionId = questionId;
        vm.reply.$save()
        .then(function(response) {
            vm.reply = new Reply();
            Question.get({id: questionId}, function(response) {
                vm.questionDetails = response;
            });
            toastr.success("Your reply has been submitted");
        })
        .catch(function() {
            toastr.error("Oops an error occurred");
        });
    };

    getQuestions();
}

module.exports = PublicProfileCtrl;


/***/ }),
/* 36 */
/***/ (function(module, exports) {

/**
 * Created by mayowa on 2/13/16.
 */

PrivateProfileCtrl.$inject = ['$scope', '$state', '$stateParams', '$http', '$location', 'CONFIG', 'UserDataOp', 'InterestDataOp', 'SettingsDataOp', 'toastr', 'Upload', 'S3UploadService', 'Question', 'Reply'];
function PrivateProfileCtrl($scope, $state, $stateParams, $http, $location, CONFIG, UserDataOp, InterestDataOp, SettingsDataOp, toastr, Upload, S3UploadService, Question, Reply){

    var vm = this;
    $scope.currentUrl = $location.absUrl();
    $scope.user = {};
    $scope.user.interests = [];
    $scope.user.expertise = [];
    $scope.remoteBucket = CONFIG.REMOTE_AWS_BUCKET;
    var Interest = InterestDataOp.Interest();
    vm.question = new Question();
    vm.reply = new Reply();
    // Get user's profile
    vm.getProfile = getPrivateProfile();

    function getPrivateProfile () {
        UserDataOp.getPrivateProfile(function(response) {
            if (response.cover_photo_url === null || response.cover_photo_url === '') {
                vm.coverPhoto = UserDataOp.defaultCoverPhoto();
            } else {
                vm.coverPhoto = {"background-image": 'url(' + response.cover_photo_url + ')'};
            }
            $scope.user = response;
            $scope.user.initials = response.first_name.charAt() + response.last_name.charAt();
        }, function(){

        });
    }

    // Fetch all the interests
    $scope.availableAreasOfInterest = Interest.query();

    // Edit Basic profile
    $scope.editBasicProfile = function() {
        $scope.edit = true;
    };

    // Update profile
    $scope.updateBasicProfile = function(){
        $scope.edit = false;
        $scope.updating = true;

        $http.post(CONFIG.API_BSE_URL + 'user/profile/basic/update', $scope.user)
            .success(function(response){

                if (response.meta.status === 1) {
                    vm.getProfile();
                    toastr.success('Your profile has been updated');
                }

            })

            .catch(function(error){
                toastr.error('Oops! Something is broken, try again later');
            })

    };

    // Update user's interest
    $scope.updateInterests = function(){
        $http.post(CONFIG.API_BSE_URL + 'user/interests/update', $scope.user)
            .success(function (response) {
                if (response.meta.status === 1) {
                    getPrivateProfile();
                    toastr.success('Your interests has been updated');
                }
            })

            .catch(function(error) {
                toastr.error('Oops! Something is broken, try again later');

            })
    };

    // Update users (mentor's) expertises
    $scope.updateExpertise = function(){
        $http.post(CONFIG.API_BSE_URL + 'mentor/expertise/update', $scope.user)
            .success(function (response){
                if (response.meta.status === 1) {
                    getPrivateProfile();
                    toastr.success('Your expertise has been updated');
                }
            })
            .error(function(error){
                if (error.status === 400) {
                    $state.go('logout');
                } else {
                    toastr.error('Oops! Something is broken, try again later');
                }
            }).catch(function(error){

            })
    };

    vm.uploadCoverPhoto = function (files) {
        $scope.Files = files;
        if (files && files.length > 0) {
            angular.forEach($scope.Files, function (file, key) {
                S3UploadService.Upload(file).then(function (response) {
                    // Update user profile url
                    var params = {
                        cover_photo_url: response.Location
                    };
                    // Update profile picture in the database with the url
                    UserDataOp.updateCoverPhoto(params, function () {
                        // get profile to update view
                        $state.go($state.current, {}, {reload: true});                        }, function (){
                        toastr.error("Unable to update profile picture at this time");
                    }, function () {

                    });

                    // Mark as success
                    file.Success = true;
                }, function (error) {
                    // Mark the error
                    $scope.Error = error;
                }, function (progress) {
                    // Write the progress as a percentage
                    file.Progress = (progress.loaded / progress.total) * 100
                });
            });
        }
    };


    function getQuestions() {
        vm.questions = Question.query({ profileType: 'private' });
    }

    function getQuestionsBySelf() {
        vm.questionsBySelf = Question.query({ askedBy: 'self' });
    };

     /**
     * @name showQuestion
     * @param {Integer} id 
     */
    vm.showQuestion = function (id) {
        Question.get({id: id}, function(response) {
            vm.questionDetails = response;
            $('#questionModal').modal({show: true});
        });
    };

      /**
     * @name postReply
     * @param {Integer} questionId
     */
    vm.postReply = function (questionId) {
        vm.reply.questionId = questionId;
        vm.reply.$save()
        .then(function(response) {
            vm.reply = new Reply();
            Question.get({id: questionId}, function(response) {
                vm.questionDetails = response;
            });
            toastr.success("Your reply has been submitted");
        })
        .catch(function() {
            toastr.error("Oops an error occurred");
        });
    };

    getQuestions();
    getQuestionsBySelf();
}
module.exports = PrivateProfileCtrl;




    


/***/ }),
/* 37 */
/***/ (function(module, exports, __webpack_require__) {

var angular = __webpack_require__(0);
angular.module('app.program', []).controller('CreateProgramCtrl', __webpack_require__(38));
angular.module('app.program').controller('DiscoverProgramCtrl', __webpack_require__(39));
angular.module('app.program').controller('InviteMenteeCtrl', __webpack_require__(40));
angular.module('app.program').controller('InviteMentorCtrl', __webpack_require__(41));
angular.module('app.program').controller('ProgramHomeCtrl', __webpack_require__(42));
angular.module('app.program').controller('ProgramMenteeCtrl', __webpack_require__(43));
angular.module('app.program').controller('ProgramMentorCtrl', __webpack_require__(44));
angular.module('app.program').controller('ProgramResourceCtrl', __webpack_require__(45));
angular.module('app.program').controller('ProgramTaskCtrl', __webpack_require__(46));
angular.module('app.program').controller('ProgramCtrl', __webpack_require__(47));

/***/ }),
/* 38 */
/***/ (function(module, exports) {

/**
 * Created by Jidesakin on 28/02/2017.
 */
 CreateProgramCtrl.$inject = ['$scope', '$state', 'MentorDataOp', 'InterestDataOp', 'ProgramDataOp', 'toastr'];
function CreateProgramCtrl ($scope, $state, MentorDataOp, InterestDataOp, ProgramDataOp, toastr) {

    var vm = this;
    var Program = ProgramDataOp.Program();
    vm.program = new Program();
    vm.program.fee = 0.0;

    vm.specializations = InterestDataOp.Interest().query();

    vm.createProgram = function (isValid) {
        if (!isValid) {
            toastr.warning("Please fill all required fields");
            return;
        }
        vm.program.specialization_id = vm.program.specialization.id;
        mixpanel.track('Create Mentorhsip Program', vm.program);
        vm.program.$save()
        .then(function (res) {
            vm.program = res.program;
            toastr.success(res.message);
            $state.go('app.inviteMentors', res.program);
        })
        .catch(function (error) {
            toastr.error("Something went wrong");
        });
    };
}

module.exports = CreateProgramCtrl;

/***/ }),
/* 39 */
/***/ (function(module, exports) {

/**
 * Created by Jidesakin on 16/05/2017.
 */
DiscoverProgramCtrl.$inject = ['$scope', '$state', 'MentorDataOp', 'ProgramDataOp', 'toastr', 'UserDataOp'];
function DiscoverProgramCtrl ($scope, $state, MentorDataOp, ProgramDataOp, toastr, UserDataOp) {

    var vm = this;
    var Program = ProgramDataOp.Program();
    vm.program = new Program();
    vm.program.fee = 0.0;

    vm.pageSize = 10;
    vm.currentPage = 1;

    vm.specializations = MentorDataOp.Specialization().query();
    vm.getPrograms = getPrograms();

    UserDataOp.getPrivateProfile(function(response){
        $scope.user = response;
        }, function(){});

    function getPrograms() {
        ProgramDataOp.Program().query({}, function (resp) {
            vm.programs = resp;
        });
    }

}

module.exports = DiscoverProgramCtrl;

/***/ }),
/* 40 */
/***/ (function(module, exports) {

/**
 * Created by Jidesakin on 30/03/2017.
 */
InviteMenteeCtrl.$inject = ['$scope', '$state', '$stateParams', 'UserDataOp', 'ProgramDataOp', 'toastr'];
function InviteMenteeCtrl ($scope, $state, $stateParams, UserDataOp, ProgramDataOp, toastr) {

    var vm = this;
    var Program = ProgramDataOp.Program();
    vm.selectedMentee = null;


    vm.mentees = UserDataOp.mentees().query();
    vm.selectedMentees = [];

    // Get Suggested mentees
    Program.get($stateParams).$promise.then(function (program) {
        vm.program = program;
        vm.suggestedMentees = UserDataOp.MenteeBySpecialization(program.specialization_id).query();
    });

    // Invite mentee
    vm.inviteMentee = function () {

        if (vm.selectedMentee !== null) {
            var params = {
                program_id: $stateParams.id,
                mentee_id: vm.selectedMentee.id
            };

            ProgramDataOp.inviteMentee(params, function () {
                vm.selectedMentee = null;
                swal({
                    title: 'Invitation sent!',
                    text: '',
                    timer: 2000,
                    type: 'success',
                }).then(
                    function () {},
                    // handling the promise rejection
                    function (dismiss) {
                        if (dismiss === 'timer') {
                            console.log('I was closed by the timer')
                        }
                    }
                );

                $state.reload();

            }, function (error) {
                swal({
                    title: 'Mentee already exist',
                    text: '',
                    timer: 2000,
                    type: 'warning',
                }).then(
                    function () {},
                    // handling the promise rejection
                    function (dismiss) {
                        if (dismiss === 'timer') {
                            console.log('I was closed by the timer')
                        }
                    }
                );
            })
        }


    };

    // Go to the program home
    vm.goToProgramHome = function () {
        $state.go('app.program.home', {id: $stateParams.id});
    };

}

module.exports = InviteMenteeCtrl;

/***/ }),
/* 41 */
/***/ (function(module, exports) {

/**
 * Created by Jidesakin on 30/03/2017.
 */
InviteMentorCtrl.$inject = ['$scope', '$state', '$stateParams', 'MentorDataOp', 'ProgramDataOp', 'toastr'];
function InviteMentorCtrl ($scope, $state, $stateParams, MentorDataOp, ProgramDataOp, toastr) {

    var vm = this;
    var Program = ProgramDataOp.Program();

    vm.mentors = MentorDataOp.mentors().query();
    vm.programMentors = [];
    vm.selectedMentor = null;

    ProgramDataOp.Program().get($stateParams).$promise.then(function(program){
        vm.program = program;
        vm.suggestedMentors = MentorDataOp.MentorBySpecialization(program.specialization_id).query();
    });

    vm.inviteMentor = function () {
       if (vm.selectedMentor !== null) {
           var params = {
               program_id: $stateParams.id,
               mentor_id: vm.selectedMentor.id
           };

           ProgramDataOp.inviteMentor(params, function() {
               vm.selectedMentor = null;
               swal({
                   title: 'Invitation sent!',
                   text: '',
                   timer: 2000,
                   type: 'success',
               }).then(
                   function () {},
                   // handling the promise rejection
                   function (dismiss) {
                       if (dismiss === 'timer') {
                           console.log('I was closed by the timer')
                       }
                   }
               );

           }, function (error) {
               swal({
                   title: 'Mentor already exist',
                   text: '',
                   timer: 2000,
                   type: 'warning',
               }).then(
                   function () {},
                   // handling the promise rejection
                   function (dismiss) {
                       if (dismiss === 'timer') {
                           console.log('I was closed by the timer')
                       }
                   }
               );
           })
       }
    };



    function getSuggestedMentors() {

    }

}

module.exports = InviteMentorCtrl;

/***/ }),
/* 42 */
/***/ (function(module, exports) {

/**
 * Created by Jidesakin on 28/02/2017.
 */

ProgramHomeCtrl.$inject = ['$state', 'ProgramDataOp', 'toastr'];
function ProgramHomeCtrl($state, ProgramDataOp, toastr) {

    var vm = this;
    vm.programId = $state.params.id;
    vm.requestToJoin = requestToJoin;

    getProgramDetails();

    function getProgramDetails() {
        ProgramDataOp.Program().get({id: vm.programId}, function (res) {
            vm.program = res;
        });
    }

    function requestToJoin(id) {
        mixpanel.track('Request to join a Mentorship Program', {'$id': id});
        ProgramDataOp.join(id, function() {
            toastr.success("Your request has been sent");
            $state.reload();
        }, function (error) {
            if (error.statusCode === 400){
                $state.go('access.login');
            } 
            toastr.info("Please login to request to join.");
        });
    }
}

module.exports = ProgramHomeCtrl;

/***/ }),
/* 43 */
/***/ (function(module, exports) {

/**
 * Created by Jidesakin on 01/01/2017.
 */
ProgramMenteeCtrl.$inject = ['$state', 'ProgramDataOp', 'UserDataOp'];
function ProgramMenteeCtrl($state, ProgramDataOp, UserDataOp) {

    var vm = this;
    vm.programId = $state.params.id;

    getProgramMentees();
    vm.defaultMenteeCoverPhoto = UserDataOp.defaultMenteeCoverPhoto();
    function getProgramMentees() {
        ProgramDataOp.ProgramMentee(vm.programId).query({}, function (resp) {
            vm.programMentees = resp;
        });
    }

}

module.exports = ProgramMenteeCtrl;

/***/ }),
/* 44 */
/***/ (function(module, exports) {

/**
 * Created by Jidesakin on 01/01/2017.
 */

ProgramMentorCtrl.$inject = ['$state', 'ProgramDataOp', 'UserDataOp'];
function ProgramMentorCtrl($state, ProgramDataOp, UserDataOp) {

    var vm = this;

    vm.programId = $state.params.id;
    vm.defaultCoverPhoto = UserDataOp.defaultCoverPhoto();

    getProgramMentors();
    function getProgramMentors() {
        ProgramDataOp.ProgramMentor(vm.programId).query({}, function (resp){
            vm.programMentors = resp;
            console.log(resp);
        })

    }
}

module.exports = ProgramMentorCtrl;

/***/ }),
/* 45 */
/***/ (function(module, exports) {

/**
 * Created by Jidesakin on 01/01/2017.
 */
ProgramResourceCtrl.$inject = ['$state', 'ProgramDataOp', 'Note', 'toastr', 'UserDataOp'];
function ProgramResourceCtrl($state, ProgramDataOp, Note, toastr, UserDataOp) {

    var vm = this;

    vm.programId = $state.params.id;
    vm.resource = new Note();

    getResources(vm.programId);

    getProgramDetails();

    function getProgramDetails() {
        ProgramDataOp.Program().get({id: vm.programId}, function (res) {
            vm.program = res;
        });
    }

    // Get user profile
    UserDataOp.getPrivateProfile(function(response){
        vm.currentUser = response;
    }, function(){});

    function getResources(programId) {
        ProgramDataOp.ProgramResource(programId)
        .query({}, function (res) {
           vm.resources = res;
        });
    }

    vm.shareResource = function() {
        vm.resource.programId = vm.programId;
        vm.resource.$save()
        .then(function(response){
            if (response.meta.status == 1){
                toastr.success("Your resource has been published");
                $state.reload();
            }
        })
        .catch(function(){
            toastr.error("Oops an error occurred");
        });
    };

    vm.getLinkPreview = function(content) {
        var uriPattern = /\b((?:[a-z][\w-]+:(?:\/{1,3}|[a-z0-9%])|www\d{0,3}[.]|[a-z0-9.\-]+[.][a-z]{2,4}\/)(?:[^\s()<>]+|\(([^\s()<>]+|(\([^\s()<>]+\)))*\))+(?:\(([^\s()<>]+|(\([^\s()<>]+\)))*\)|[^\s`!()\[\]{};:'".,<>?«»“”‘’]))/ig;
        var link = content.match(uriPattern);

    };

    vm.getIframeSrc = function (src) {
        var youtubeId = src.split('/').reverse()[0]
        console.log(youtubeId)
        return 'https://www.youtube.com/embed/' + youtubeId;
    }
}

module.exports = ProgramResourceCtrl;

/***/ }),
/* 46 */
/***/ (function(module, exports) {

/**
 * Created by Jidesakin on 01/01/2017.
 */
ProgramTaskCtrl.$inject = ['$state', 'Task', 'toastr', 'ProgramDataOp', '$http', 'CONFIG', 'UserDataOp'];

function ProgramTaskCtrl($state, Task, toastr, ProgramDataOp, $http, CONFIG, UserDataOp) {
    var vm = this;
    vm.programId = $state.params.id;
    vm.task = new Task();
    vm.assignment = {};
    getProgramDetails();
    getTasks();

    function getProgramDetails() {
        ProgramDataOp.Program().get({id: vm.programId}, function (res) {
            vm.program = res;
        });
    }

    // Get user profile
    UserDataOp.getPrivateProfile(function(response){
        vm.currentUser = response;
    }, function(){});
    
    function getTasks() {
        vm.tasks = Task.query({ programId: vm.programId });
    }

    vm.createTask = function() {
        vm.task.programId = vm.programId;
        vm.task.$save()
        .then(function (response) {
            vm.task = new Task();
            getTasks();
            toastr.success('Task created successfully');
        })
        .catch(function() {
            toastr.error('Unable to create task');
        });
    };

    vm.showTask = function (id) {
        Task.get({id: id}, function(response) {
            vm.taskDetails = response;
            $('#taskModal').modal({show: true});
        });
    };

    vm.assign = function (taskId) {
        vm.assignment.userId = vm.selectedMentee.id;
        vm.assignment.taskId = vm.taskDetails.id;
        $http.post(CONFIG.API_BSE_URL + 'tasks/assignees', vm.assignment)
        .then(function(response) {
            Task.get({id: vm.taskDetails.id}, function(response) {
                vm.taskDetails = response;
                vm.assignment = {};
                toastr.success('Task was assigned successfully');
            });
        })
        .catch(function(error) {
            toastr.error('Unable to assign task to selected user');
        });
    };

    function getProgramMentees() {
        ProgramDataOp.ProgramMentee(vm.programId).query({}, function (resp) {
            vm.programMentees = resp;
        });
    }

    getProgramMentees();
}

module.exports = ProgramTaskCtrl;

/***/ }),
/* 47 */
/***/ (function(module, exports) {

/**
 * Created by Jidesakin on 25/04/2017.
 */
ProgramCtrl.$inject = ['$state', '$stateParams', 'UserDataOp', '$scope'];
function ProgramCtrl($state, $stateParams, UserDataOp, $scope) {
    var vm = this;
    vm.programId = $state.params.id;
    UserDataOp.getPrivateProfile(function(response){
        $scope.user = response;
        }, function(){});
}

module.exports = ProgramCtrl;

/***/ }),
/* 48 */
/***/ (function(module, exports, __webpack_require__) {

var angular = __webpack_require__(0);
angular.module('app.searchResult', []).controller('SearchResultCtrl', __webpack_require__(49));

/***/ }),
/* 49 */
/***/ (function(module, exports) {

/**
 * Created by Jidesakin on 25/05/2017.
 */
SearchResultCtrl.$inject = ['$stateParams', 'results', '$state', 'UserDataOp', '$scope'];

function SearchResultCtrl ($stateParams, results, $state, UserDataOp, $scope) {

    var vm = this;
    vm.query = $stateParams.query;
    vm.results = results.data;
    vm.currentPage = 1;
    vm.pageSize = 10;
    vm.defaultCoverPhoto = UserDataOp.defaultCoverPhoto();

    vm.search = function () {
        mixpanel.track('Opened Search', {
            '$query': vm.query
        });
        $state.go('app.searchResults', {query: vm.interest});
    }
   
    $scope.concatExpertise = function(expertise) {
        var expertiseNames = expertise.map(function(item) {
            return item.name;
        });
        return expertiseNames.join(', ');
    };

}

module.exports = SearchResultCtrl;

/***/ }),
/* 50 */
/***/ (function(module, exports, __webpack_require__) {

var angular = __webpack_require__(0);
angular.module('app.mentoringSession', []).controller('MentoringSessionCtrl', __webpack_require__(51));
angular.module('app.mentoringSession').controller('ViewMentoringSessionCtrl', __webpack_require__(52));

/***/ }),
/* 51 */
/***/ (function(module, exports) {

/**
 * Created by jidesakin on 8/22/16.
 */

MentoringSessionCtrl.$inject = ['$scope', 'CONFIG', '$state', 'MentorDataOp', 'toastr'];
function MentoringSessionCtrl($scope, CONFIG, $state, MentorDataOp, toastr){

    $scope.FILE_PATH = CONFIG.FILE_PATH;

    var vm = this;

    $scope.showEmptyState = false;

    // var mentoringSessions = MentoringSessions.$loaded();

    // console.log(mentoringSessions);

    $scope.pageSize = 10;
    $scope.currentPage = 1;

    var MentoringSession = MentorDataOp.MentoringSession();

    // Get mentoring sessions
    vm.getMentoringSessions = function () {
        $scope.mentoringSessions = MentoringSession.query(function(){
            if ($scope.mentoringSessions.length === 0) {
                $scope.showEmptyState = true;
            }
        });
    };


    // Returns the expertise ef the authenticated mentor
    MentorDataOp.getExpertise(function (response) {
        $scope.mentoringAreas = response.data.expertise;
    }, function () {
        // Do something
    });


    $scope.mentoringSession = new MentoringSession();

    vm.saveMentoringSession = function () {
        $scope.mentoringSession.mentoring_area_id = $scope.mentoringSession.mentoringArea;
        // mentoringSessionCtrl.mentoringSessions.$add($scope.mentoringSession);
        $scope.mentoringSession.$save()
            .then(function (res) {
                toastr.info("Your Mentoring session has been created");
                $state.go('app.mentoringSessions.index', {reload: true});
             })
            .catch(function (error) {
                toastr.error("Oops! Something went wrong. Please try again later");
            })
    };

    vm.getMentoringSessions();

}

module.exports = MentoringSessionCtrl;



/***/ }),
/* 52 */
/***/ (function(module, exports) {

/**
 * Created by jidesakin on 12/6/16.
 */
ViewMentoringSessionCtrl.$inject = ['$scope', 'CONFIG', '$state', 'MentorDataOp', '$stateParams', 'MentoringSessionDataOp', 'toastr', '$mdSidenav', '$interval', '$auth', '$location', 'UserDataOp'];
function ViewMentoringSessionCtrl($scope, CONFIG, $state, MentorDataOp, $stateParams, MentoringSessionDataOp, toastr, $mdSidenav, $interval, $auth, $location, UserDataOp){
    var vm = this;
    var MentoringSession = MentorDataOp.MentoringSession();
    var Post = MentoringSessionDataOp.Post();
    var Reply = MentoringSessionDataOp.Reply();
    $scope.post = new Post();
    vm.reply = new Reply();
    vm.showPostBox = vm.showJoinBox = vm.showBeTheFirstBox = false;

    vm.showParticipantAlert = false;

    vm.coverPhoto = UserDataOp.defaultCoverPhoto();


    // Get the details of the mentoring session
    vm.getMentoringSessionDetails = function () {
        MentoringSession.get({id: $stateParams.id}).$promise.then(function(res){
            $scope.mentoringSession = res.mentoringSession;
            vm.showPostBox = res.mentoringSession.allow_user_participate;
            vm.showJoinBox = !vm.showPostBox;
        });

    };


    // Submit a new post
    vm.submitPost = function () {
        $scope.post.mentoring_session_id = $stateParams.id;
        $scope.post.$save()
            .then(function () {
                vm.getMentoringSessionDetails();
                toastr.info('Your post has been submitted.');
                mixpanel.track('Submitted Post on Mentoring Session', {'name': $scope.mentoringSession.name, 'mentor': $scope.mentoringSession.creator.name});
            })
            .catch(function () {
                toastr.warning("Oops! Something went wrong. Please try again later");
            })

    };

    // Allow current user to join the mentoring session
    vm.join = function () {

        if (!$auth.isAuthenticated()) {
            toastr.info('You need to login to participate');
            localStorage.setItem('prevUrl', $location.path());

            $location.path('/login');

            return;
        }

        var data = {
            id: $scope.mentoringSession.id
        };
        MentoringSessionDataOp.join(data, function (res) {
            mixpanel.track('Joined Mentoring Session');
            toastr.success('Success!');
            vm.showPostBox = true;
            vm.showJoinBox = !vm.showPostBox;
            $state.reload();
        }, function () {

        });
    };

    // Upvote a post
    vm.upvotePost = function(responseId) {
        var params = {
            id: responseId
        };
        MentoringSessionDataOp.upvotePost(params, function(res) {
            console.log(res);
        }, function(error) {
            console.log(error);
        })
    };

    // Get the post details
    vm.getPostDetails = function (id) {
        Post.get({id: id}).$promise.then(function (res) {
            vm.post = res;
        }).catch(function (){
            toastr.error('Oops! Something went wrong. Try again later');
        });

    };


    // Show reply box
    vm.showReplyBox = function (postId) {
        vm.getPostDetails(postId);
        $mdSidenav('right').toggle();
    };


    // Submit reply
    vm.submitReply = function () {
        vm.reply.post_id = vm.post.id;
        vm.reply.$save()
            .then(function(res) {
                vm.getPostDetails(res.mentoring_session_post_id);
                vm.reply.text = '';
                toastr.info("Reply submitted");
            })
            .catch(function() {
                toastr.error('Oops! Something went wrong. Try again later');
            });

    };

    // Run functions
    vm.getMentoringSessionDetails();

}

module.exports = ViewMentoringSessionCtrl;

/***/ }),
/* 53 */
/***/ (function(module, exports, __webpack_require__) {

var angular = __webpack_require__(0);
angular.module('app.settings', []).controller('SettingsCtrl', __webpack_require__(54));

/***/ }),
/* 54 */
/***/ (function(module, exports) {

/**
 * Created by jidesakin on 7/17/16.
 */
SettingsCtrl.$inject = ['$scope', '$state', 'UserDataOp', 'toastr', 'SettingsDataOp', 'CONFIG', 'Upload', 'S3UploadService'];
function SettingsCtrl ($scope, $state, UserDataOp, toastr, SettingsDataOp, CONFIG, Upload, S3UploadService){

    var vm = this;

    vm.experienceHeader = "Add experience";
    vm.educationBoxHeader = "Add education";
    vm.showUpdateBtn = false;
    vm.showDoneBtn = false;
    var Education = SettingsDataOp.Education();
    var Experience = SettingsDataOp.Experience();
    $scope.user = {};
    $scope.file = null;
    $scope.experience = new Experience();
    $scope.education = new Education();
    $scope.educations = Education.query();
    $scope.experiences = Experience.query();

    vm.getPrivateProfile = getPrivateProfile();

    function getPrivateProfile () {
        UserDataOp.getPrivateProfile(function(response){
            $scope.user = response;
        }, function(){
            toastr.error('Oops! An error occurred, please check you network connection');
        });
    }

    vm.editEducation = function () {
        vm.experienceHeader = "Add experience";
        vm.educationBoxHeader = "Add education";
    };

    vm.editExperience = function(){

    };

    vm.updateBasicProfile = function(){
        UserDataOp.updateBasicProfile($scope.user, function(response){
            toastr.info('Update Successful');
        }, function(){
            toastr.error("Oops! An error occurred. Please try again later");
        });

    };

    vm.saveEducation = function (){
        $scope.education.$save(function(){
            toastr.info('Education saved');
            $scope.educations = Education.query();
        });
    };

    vm.saveExperience = function () {
        $scope.experience.$save(function(){
            toastr.info('Record saved');
            $scope.experiences = Experience.query();

        });
    };

    vm.uploadProfilePicture = function (files) {
        $scope.Files = files;
        if (files && files.length > 0) {
            angular.forEach($scope.Files, function (file, key) {
                S3UploadService.Upload(file).then(function (response) {
                    // Update user profile url
                    var params = {
                        profile_picture_url: response.Location
                    };

                    // Update profile picture in the database with the url
                    UserDataOp.updateProfilePicture(params, function () {
                        // get profile to update view
                        getPrivateProfile();
                    }, function (){
                        toastr.error("Unable to update profile picture at this time");
                    });

                    // Mark as success
                    file.Success = true;
                }, function (error) {
                    // Mark the error
                    $scope.Error = error;
                }, function (progress) {
                    // Write the progress as a percentage
                    file.Progress = (progress.loaded / progress.total) * 100
                });
            });
        }

    };

}

module.exports = SettingsCtrl;


/***/ }),
/* 55 */
/***/ (function(module, exports, __webpack_require__) {

var angular = __webpack_require__(0)
angular.module('app.question', []).controller('QuestionCtrl', __webpack_require__(56));

/***/ }),
/* 56 */
/***/ (function(module, exports) {

QuestionCtrl.$inject = ['$scope', '$state', 'toastr', 'Question', 'Reply'];
function QuestionCtrl ($scope, $state, toastr, Question, Reply) {
  var vm = this;
  var id = $state.params.id;
  vm.question = new Question();
  vm.reply = new Reply();
   

  Question.get({id: id}, function(response) {
    vm.questionDetails = response;
    mixpanel.track('Get Question', {
    });
  });
    
  /**
  * @name postReply
  * @param {Integer} questionId
  */
  vm.postReply = function (questionId) {
    vm.reply.questionId = questionId;
    vm.reply.$save()
    .then(function(response) {
        vm.reply = new Reply();
        Question.get({id: questionId}, function(response) {
            vm.questionDetails = response;
        });
        mixpanel.track('Submitted Reply', {
        });
        toastr.success("Your reply has been submitted");
    })
    .catch(function() {
        toastr.error("Oops an error occurred");
    });
  };
}

module.exports = QuestionCtrl;

/***/ }),
/* 57 */
/***/ (function(module, exports, __webpack_require__) {

var angular = __webpack_require__(0);
angular.module('interestService', ['ngResource']).factory('InterestDataOp', __webpack_require__(58));
angular.module('mentorService', ['ngResource']).factory('MentorDataOp', __webpack_require__(59));
angular.module('menteeService', ['ngResource']).factory('MenteeDataOp', __webpack_require__(60));
angular.module('mentoringSessionService', ['ngResource']).factory('MentoringSessionDataOp', __webpack_require__(61));
angular.module('noteService', ['ngResource']).factory('Note', __webpack_require__(62));
angular.module('programService', ['ngResource']).factory('ProgramDataOp', __webpack_require__(63));
angular.module('questionService', ['ngResource']).factory('Question', __webpack_require__(64));
angular.module('replyService', ['ngResource']).factory('Reply', __webpack_require__(65));
angular.module('s3uploadService', []).service('S3UploadService', __webpack_require__(66));
angular.module('searchService', ['ngResource']).factory('Search', __webpack_require__(67));
angular.module('settingsService', ['ngResource']).factory('SettingsDataOp', __webpack_require__(68));
angular.module('taskService', ['ngResource']).factory('Task', __webpack_require__(69));
angular.module('userService', ['ngResource']).factory('UserDataOp', __webpack_require__(70));
angular.module('upvoteService', ['ngResource']).factory('UpvoteDataOp', __webpack_require__(71));
angular.module('resourceService', ['ngResource']).factory('ResourceDataOp', __webpack_require__(72));
angular.module('miscService', ['ngResource']).factory('MiscDataOp', __webpack_require__(73));


/***/ }),
/* 58 */
/***/ (function(module, exports) {

/**
 * Created by Jidesakin on 13/06/2017.
 */
interestService.$inject = ['$resource', 'CONFIG'];
function interestService($resource, CONFIG){
    return {
        Interest: function () {
            return $resource(CONFIG.API_BSE_URL + 'specializations/:id', {id:'@_id'},
                {
                    update: {
                        method: 'PUT'
                    }
                });
            }
    };
}

module.exports = interestService

/***/ }),
/* 59 */
/***/ (function(module, exports) {

/**
 * Created by jidesakin on 2/10/16.
 */
MentorService.$inject = ['$http', 'CONFIG', '$resource'];
function MentorService($http, CONFIG, $resource) {

    var MentorDataOp = {};

    MentorDataOp.Specialization = function () {
        return $resource(CONFIG.API_BSE_URL + 'specializations/:id', {id:'@_id'},
            {
                update:{
                    method: 'PUT'
                }
            })
    };

    MentorDataOp.MentoringApplication = function() {
        return $resource(CONFIG.API_BSE_URL + 'mentoring_applications/:id', {id: '@_id'},
            {
                update: {
                    method: 'PUT'
                }
            })
    };

    MentorDataOp.mentors = function () {
        return $resource(CONFIG.API_BSE_URL + 'mentors/:id', {id: '@_id'},
            {
                update: {
                    method: 'PUT'
                }
            })
    };

    MentorDataOp.MentorYouFollow = function() {
        return $resource(CONFIG.API_BSE_URL + 'mentors/auth/follow/:id', {id: '@_id'},
            {
                update: {
                    method: 'PUT'
                }
            })
    };

    MentorDataOp.FeaturedMentors = function() {
        return $resource(CONFIG.API_BSE_URL + 'mentors/featured')
    };

    MentorDataOp.MentoringSession = function () {
        return $resource(CONFIG.API_BSE_URL + 'mentoring_sessions/:id', {id: '@_id'},
            {
                update: {
                    method: 'PUT'
                }
            })
    };

    MentorDataOp.getExpertise = function (success, error) {
        return $http.get(CONFIG.API_BSE_URL + 'user/expertise').success(success).error(error);
    };

    MentorDataOp.MentorBySpecialization = function(id) {
        return $resource(CONFIG.API_BSE_URL + 'specializations/' + id + '/mentors', {id: '@_id'},
            {
                update: {
                    method: 'PUT'
                }
            })
    };


    return MentorDataOp;

}

module.exports = MentorService

/***/ }),
/* 60 */
/***/ (function(module, exports) {

/**
 * Created by jidesakin on 2/10/16.
 */
MenteeService.$inject = ['$http', 'CONFIG', '$resource'];
function MenteeService($http, CONFIG, $resource) {
    var MenteeDataOp = {};
    MenteeDataOp.mentees = function () {
        return $resource(CONFIG.API_BSE_URL + 'mentees/:id', {id: '@_id'},
            {
                update: {
                    method: 'PUT'
                }
            })
    };
    return MenteeDataOp;
}

module.exports = MenteeService;

/***/ }),
/* 61 */
/***/ (function(module, exports) {

/**
 * Created by jidesakin on 9/12/16.
 */
MentoringSessionService.$inject = ['$http', '$resource', 'CONFIG']
function MentoringSessionService($http, $resource, CONFIG) {

    var MentoringSessionDataOp = {};
    MentoringSessionDataOp.Post = function () {

        return $resource(CONFIG.API_BSE_URL + 'mentoring_session/posts/:id', {id: '@_id'}, {

            update: {
                method: 'PUT'
            }
        })
    };


    MentoringSessionDataOp.join = function (data, success, error) {
        return $http.post(CONFIG.API_BSE_URL + 'mentoring_session/join', data).success(success).error(error);
    };


    // Upvote post
    MentoringSessionDataOp.upvotePost = function (params, success, error) {
        return $http.post(CONFIG.API_BSE_URL + 'mentoring_session/post/upvote', params).success(success).error(error);
    };

    MentoringSessionDataOp.UpcomingSession = function() {

      return $resource(CONFIG.API_BSE_URL + 'mentoring_session/upcoming/:id', {id: '@_id'}, {

          update: {
              method: 'PUT'
          }
      })

    };

    // Reply
    MentoringSessionDataOp.Reply = function () {

        return $resource(CONFIG.API_BSE_URL + 'replies', {id: '@_id'}, {
            update: {
                method: 'PUT'
            }
        })
    };


    return MentoringSessionDataOp;

}

module.exports = MentoringSessionService;


/***/ }),
/* 62 */
/***/ (function(module, exports) {

/**
 * Created by jidesakin on 2/13/16.
 */
noteService.$inject = ['$resource', 'CONFIG'];
function noteService($resource, CONFIG){
    return $resource(CONFIG.API_BSE_URL + 
        'resources/:id', {id:'@_id'},
        {
            update:{
                method: 'PUT',
            },
        });
}
module.exports = noteService;


/***/ }),
/* 63 */
/***/ (function(module, exports) {

/**
 * Created by Jidesakin on 28/02/2017.
 */
ProgramService.$inject = ['$http', '$resource', 'CONFIG'];
function ProgramService($http, $resource, CONFIG) {

    var ProgramDataOp = {};

    ProgramDataOp.Program = function () {
        return $resource(CONFIG.API_BSE_URL + 'programs/:id', {id: '@_id'}, {
            update: {
                method: 'PUT'
            }
        })
    };

    ProgramDataOp.ProgramMentor = function (id) {
        return $resource(CONFIG.API_BSE_URL + 'programs/' + id + '/mentors', {id: '@_id'}, {
            update: {
                method: 'PUT'
            }
        });
    };

    ProgramDataOp.ProgramMentee = function (id) {
        return $resource(CONFIG.API_BSE_URL + 'programs/' + id + '/mentees', {id: '@_id'}, {
            update: {
                method: 'PUT'
            }
        });
    };

    ProgramDataOp.ProgramResource = function (id) {
        return $resource(CONFIG.API_BSE_URL + 'programs/' + id + '/resources', {id: '@_id'}, {
            update: {
                method: 'PUT'
            }
        });
    };

    ProgramDataOp.inviteMentor = function (params, success, error) {
        return $http.post(CONFIG.API_BSE_URL + 'program/invite_mentor', params).success(success).error(error);
    };

    ProgramDataOp.inviteMentee = function (params, success, error) {
        return $http.post(CONFIG.API_BSE_URL + 'program/invite_mentee', params).success(success).error(error);
    };

    ProgramDataOp.join = function (id, success, error) {
        return $http.post(CONFIG.API_BSE_URL + 'programs/' + id + '/join').success(success).error(error);
    };


    // Upvote post
    ProgramDataOp.upvotePost = function (params, success, error) {
        return $http.post(CONFIG.API_BSE_URL + 'mentoring_session/post/upvote', params).success(success).error(error);
    };


    // Reply
    ProgramDataOp.Reply = function () {
        return $resource(CONFIG.API_BSE_URL + 'replies', {id: '@_id'}, {
            update: {
                method: 'PUT'
            }
        })
    };    

    return ProgramDataOp;

}

module.exports = ProgramService;


/***/ }),
/* 64 */
/***/ (function(module, exports) {

/**
 * Created by jidesakin on 2/13/16.
 */

questionService.$inject = ['$resource', 'CONFIG'];
function questionService($resource, CONFIG){
    return $resource(CONFIG.API_BSE_URL + 'questions/:id', {id:'@_id'},
        {
            update:{
                method: 'PUT',
            },
        });
}

module.exports = questionService;

/***/ }),
/* 65 */
/***/ (function(module, exports) {

/**
 * @author Babajide Owosakin
 */
replyService.$inject = ['$resource', 'CONFIG'];
function replyService($resource, CONFIG){
    return $resource(CONFIG.API_BSE_URL + 'replies/:id', {id:'@_id'},
        {
            update:{
                method: 'PUT',
            },
        });
}

module.exports = replyService;

/***/ }),
/* 66 */
/***/ (function(module, exports) {

/**
 * @author Babajide Owosakin
 * Created by Jidesakin on 17/12/2016.
 */

s3uploadService.$inject = ['$q', 'CONFIG'];
function s3uploadService($q, CONFIG) {
    AWS.config.region = CONFIG.S3_CREDENTIALS.region;
    AWS.config.update({ accessKeyId: CONFIG.S3_CREDENTIALS.access_key, secretAccessKey: CONFIG.S3_CREDENTIALS.secret_key });

    var bucket = new AWS.S3({ params: { Bucket: CONFIG.S3_CREDENTIALS.bucket, maxRetries: 10 }, httpOptions: { timeout: 360000 } });
    this.Progress = 0;
    this.Upload = function (file) {
        var deferred = $q.defer();
        var params = { Bucket: CONFIG.S3_CREDENTIALS.bucket, Key: file.name, ContentType: file.type, Body: file };
        var options = {
            // Part Size of 10mb
            partSize: 10 * 1024 * 1024,
            queueSize: 1,
            // Give the owner of the bucket full control
            ACL: 'bucket-owner-full-control'
        };
        var uploader = bucket.upload(params, options, function (err, data) {
            if (err) {
                deferred.reject(err);
            }
            deferred.resolve(data);
        });
        uploader.on('httpUploadProgress', function (event) {
            deferred.notify(event);
        });

        return deferred.promise;
    };

}

module.exports = s3uploadService;


/***/ }),
/* 67 */
/***/ (function(module, exports) {

/**
 * Created by Jidesakin on 11/06/2017.
 */
function SearchService($resource, CONFIG){

    return $resource(CONFIG.API_BSE_URL + 'resources/:id', {id:'@_id'},
        {
            update:{
                method: 'PUT'
            }
        })
}

module.exports = SearchService;

/***/ }),
/* 68 */
/***/ (function(module, exports) {

/**
 * Created by jidesakin on 8/4/16.
 */

SettingsService.$inject = ['$http', 'CONFIG', '$resource'];
function SettingsService($http, CONFIG, $resource) {

    var SettingsDataOp = {};

    SettingsDataOp.Education = function () {
        return $resource(CONFIG.API_BSE_URL + 'educations/:id', {id:'@_id'}, {
            update:{
                method: 'PUT'
            }
        })
    };
    
    SettingsDataOp.Experience = function () {
        return $resource(CONFIG.API_BSE_URL + 'experiences/:id', {id:'@_id'}, {
            update:{
                method: 'PUT'
            }
        })
    };


    // Generates a unique name and returns a string
    SettingsDataOp.getUniqueName = function (){

        var text     = "";
        var possible = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";

        for( var i=0; i < 8; i++ ) {
            text += possible.charAt(Math.floor(Math.random() * possible.length));
        }

        return text;

    };


    // Returns size file size label
    SettingsDataOp.getFileSizeLabel = function(sizeLimit) {
        // Convert Bytes To MB
        return Math.round(sizeLimit / 1024 / 1024) + 'MB';
    };

    

    return SettingsDataOp;


}

module.exports = SettingsService;

/***/ }),
/* 69 */
/***/ (function(module, exports) {

/**
 * @author Babajide Owosakin
 */

TaskService.$inject = ['$resource', 'CONFIG'];
function TaskService($resource, CONFIG){
    return $resource(CONFIG.API_BSE_URL + 'tasks/:id', {id:'@_id'},
        {
            update:{
                method: 'PUT',
            },
        });
}

module.exports = TaskService;

/***/ }),
/* 70 */
/***/ (function(module, exports) {

/**
 * Created by jidesakin on 6/25/16.
 */
UserService.$inject = ['$http', 'CONFIG', '$resource'];
function UserService($http, CONFIG, $resource){

    var UserDataOp = {};

    UserDataOp.getPublicProfile = function (userId, success, error) {
        return $http.get(CONFIG.API_BSE_URL + 'users/' + userId + '/profile/public').success(success).error(error);
    };
    
    UserDataOp.discoverPeople = function (){
        return $resource(CONFIG.API_BSE_URL + 'people/:id', {id:'@_id'},
            {
                update: {
                    method: 'PUT'
                }
            })
    };

    UserDataOp.getPrivateProfile = function (success, error){
        
        return $http.get(CONFIG.API_BSE_URL + 'auth/user').success(success).error(error);  
    };
    
    
    UserDataOp.getFollowers = function (){
        
        return $resource(CONFIG.API_BSE_URL + 'users/:id/followers', {id:'@_id'}, {
                update:{
                    method: 'PUT'
                }
            })
    };
    
    UserDataOp.getFollowing = function () {

        return $resource(CONFIG.API_BSE_URL + 'users/:id/following', {id:'@_id'}, {
            update:{
                method: 'PUT'
            }
        })
    };
    
    UserDataOp.follow = function (id, success, error) {

        return $http.post(CONFIG.API_BSE_URL + 'user/follow', {user_id:id}).success(success).error(error)

    };
    
    UserDataOp.unfollow = function (id, success, error) {
        return $http.post(CONFIG.API_BSE_URL + 'user/unfollow', {user_id:id}).success(success).error(error)
    };
    
    
    UserDataOp.register = function (userData, success, error) {
        return $http.post(CONFIG.API_BSE_URL + 'auth/register', userData).success(success).error(error);  
    };
    
    UserDataOp.onBoard = function (userData, success, error) {
        return $http.post(CONFIG.API_BSE_URL + 'user/onboard', userData).success(success).error(error);  
    };


    
    
    UserDataOp.getMatchedMentors = function (success, error) {
        return $http.get(CONFIG.API_BSE_URL + 'mentors/matched').success(success).error(error);
    };

    UserDataOp.updateBasicProfile = function (basicProfile, success, error) {

        return $http.post(CONFIG.API_BSE_URL + 'user/profile/basic/update', basicProfile).success(success).error(error);
    };

    UserDataOp.updateInterests = function (interests, success, error) {
      return $http.post(CONFIG.API_BSE_URL + 'user/interests/update', interests).success(success).error(error);
    };


    UserDataOp.verifyPasswordReset = function (params, success, error) {
        return $http.post(CONFIG.API_BSE_URL + 'user/profile/basic/update', params).success(success).error(error);

    };

    UserDataOp.Interest = function () {
        return $resource(CONFIG.API_BSE_URL + 'interests', {id:'@_id'}, {
            update:{
                method: 'PUT'
            }
        })
    };

    UserDataOp.verifyAccount = function (token, success, error) {
      return $http.get(CONFIG.API_BSE_URL + 'auth/verify_account?token=' + token).success(success).error(error);
    };

    UserDataOp.updateProfilePicture = function (params, success, error) {
        return $http.post(CONFIG.API_BSE_URL + 'user/profile_picture/update', params).success(success).error(error);
    };

    UserDataOp.updateCoverPhoto = function (params, success, error) {
        return $http.post(CONFIG.API_BSE_URL + 'user/cover_photo/update', params).success(success).error(error);
    };

    UserDataOp.defaultCoverPhoto = function () {
        return {"background-image": '', "background-color" : "#14a5e0"};
    };

    UserDataOp.defaultMenteeCoverPhoto = function () {
        return {"background-image": '', "background-color" : "#939393"};
    };

    UserDataOp.confirmPasswordReset = function (params, success, error) {
        return $http.post(CONFIG.API_BSE_URL + 'password/confirm_reset', params).success(success).error(error);
    };

    UserDataOp.resetPassword = function (params, success, error) {
        return $http.post(CONFIG.API_BSE_URL + 'password/reset', params).success(success).error(error);
    };

    UserDataOp.refreshToken = function (params, success, error) {
      return $http.post(CONFIG.API_BSE_URL + 'refresh_token', params).success(success).error(error);
    };

    UserDataOp.MenteeBySpecialization = function (specializationId) {
      return $resource(CONFIG.API_BSE_URL + 'specializations/' + specializationId + '/mentees', {id: '@_id'}, {
          update: {
              method: 'PUT'
          }
      })
    };

    UserDataOp.mentees = function () {
        return $resource(CONFIG.API_BSE_URL + 'mentees', {id: '@_id'}, {
            update: {
                method: 'PUT'
            }
        })
    };

     
    return UserDataOp;

}

module.exports = UserService;

/***/ }),
/* 71 */
/***/ (function(module, exports) {

/**
 * Created by jidesakin on 9/12/16.
 */
UpvoteService.$inject = ['$http', '$resource', 'CONFIG']
function UpvoteService($http, $resource, CONFIG) {

    var UpvoteDataOp = {};
    UpvoteDataOp.Resource = function (params, success, error) {
      return $http.post(CONFIG.API_BSE_URL + 'resource/upvote', params).success(success).error(error);
    };

    // Upvote post
    UpvoteDataOp.Question = function (params, success, error) {
        return $http.post(CONFIG.API_BSE_URL + 'question/upvote', params).success(success).error(error);
    };

    UpvoteDataOp.Reply = function (params, success, error) {
      return $http.post(CONFIG.API_BSE_URL + 'reply/upvote', params).success(success).error(error);
  };

    return UpvoteDataOp;
}

module.exports = UpvoteService;


/***/ }),
/* 72 */
/***/ (function(module, exports) {

/**
 * Created by jidesakin on 8/4/16.
 */

ResourceService.$inject = ['$http', 'CONFIG', '$resource'];
function ResourceService($http, CONFIG, $resource) {

    var ResourceDataOp = {};

    ResourceDataOp.TopResource = function() {
      return $resource(CONFIG.API_BSE_URL + 'resource/top')
    };

    return ResourceDataOp;
}

module.exports = ResourceService;

/***/ }),
/* 73 */
/***/ (function(module, exports) {

MiscService.$inject = ['$http', 'CONFIG', '$resource'];
function MiscService($http, CONFIG, $resource) {
    var MiscDataOp = {};
    MiscDataOp.PublicQuestions = function () {
        return $resource(CONFIG.API_BSE_URL + 'public/questions')
    };
    return MiscDataOp;
}

module.exports = MiscService;

/***/ })
],[1]);