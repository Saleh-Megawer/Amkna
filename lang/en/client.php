<?php
return [

    /*
    |--------------------------------------------------------------------------
    | Common
    |--------------------------------------------------------------------------
    */
    'update'             => 'Update',
    'save'               => 'Save',

    /*
    |--------------------------------------------------------------------------
    | Auth
    |--------------------------------------------------------------------------
    */
    'login'              => [
        'title'       => 'Sign in to :app',
        'description' => 'Sign in to explore properties, track your interests, and manage your requests with ease.',
        'form'        => [
            'phone_or_email' => 'Phone or Email',
            'password'       => 'Password',
            'forgot'         => 'Forgot password?',
            'submit'         => 'Sign in',
            'new_to'         => 'New to :app? Join now',
        ],
    ],

    'register'           => [
        'title'       => 'Create your :app account',
        'description' => 'Save properties, track your interests, and see which listings you\'ve contacted — all in one place.',
        'form'        => [
            'name'             => 'Name',
            'name_placeholder' => 'First & Last Name',
            'email'            => 'Email (Optional)',
            'phone'            => 'Phone',
            'phone_number'     => 'Phone Number',
            'password'         => 'Password',
            'submit'           => 'Register',
            'have_account'     => 'Have an account? Login',
            'password_help'    => 'Use 8+ chars with upper/lowercase and a number.',
        ],
    ],

    'forget_password'    => [
        'title'         => 'Forgot Password?',
        'description'   => 'Enter your email address and we\'ll send you a link to reset your password',
        'email_label'   => 'Email Address',
        'send_button'   => 'Send Reset Link',
        'back_to_login' => 'Login',
        'home'          => 'Home',
        'help_text'     => 'Didn\'t receive the email? Check your spam folder',
    ],

    'reset_password'     => [
        'title'                       => 'Reset Password',
        'email_label'                 => 'Email Address',
        'password_label'              => 'New Password',
        'password_confirmation_label' => 'Confirm Password',
        'submit_button'               => 'Reset Password',
        'back_to_login'               => 'Login',
        'home'                        => 'Home',
    ],

    /*
    |--------------------------------------------------------------------------
    | Dashboard
    |--------------------------------------------------------------------------
    */
    'dashboard'          => [
        'total_units'              => 'Total Units',
        'active_requests'          => 'Active Requests',
        'pending_requests'         => 'Pending Requests',
        'total_requests'           => 'Total Requests',
        //
        'my_associations'          => 'Owner Associations',
        'units'                    => 'unit(s)',
        'view_details'             => 'View Details',
        'no_associations'          => 'No associations found',
        //
        'latest_requests'          => 'Latest Requests',
        'view_all'                 => 'View All',
        'no_requests'              => 'No requests found',
        'admin_updates'            => 'Latest Updates',
        'no_admin_updates'         => 'No updates available',
        //
        'profile_incomplete_alert' => 'Please complete your profile information (National ID, Date of Birth, National Address) to fully use the system services.',
        'complete_profile'         => 'Complete Profile',

    ],

    /*
    |--------------------------------------------------------------------------
    | Polls
    |--------------------------------------------------------------------------
    */
    'polls'              => [
        'page_title'        => 'Polls',
        'subtitle'          => 'Participate in important decisions',
        'votes'             => 'vote',
        'voted'             => 'Voted',
        'pending'           => 'Pending',
        'unvoted'           => 'Not Voted',
        'closed'            => 'Closed',
        'view_details'      => 'View Details',
        'vote_now'          => 'Vote Now',
        'no_polls'          => 'No polls available',
        // Show page
        'poll_details'      => 'Poll Details',
        'not_authorized'    => 'You are not authorized to participate in this poll',
        'closed_error'      => 'This poll is currently closed',
        'already_voted'     => 'You have already voted',
        'vote_success'      => 'Your vote has been recorded successfully',
        'results'           => 'Results',
        'thank_you'         => 'Thank you for your vote!',
        'select_option'     => 'Select your answer',
        'submit_vote'       => 'Submit Vote',
        'active'            => 'Active',
        'created_at'        => 'Created at',
        'ends_at'           => 'Ends at',
        //
        'yes'               => 'Yes',
        'no'                => 'No',
        'your_notes'        => 'Your Notes',
        'notes_optional'    => 'Notes (Optional)',
        'notes_placeholder' => 'Add any notes or comments about your vote...',
    ],

    /*
    |--------------------------------------------------------------------------
    | 
    |--------------------------------------------------------------------------
    */
    'owner_associations' => [
        'title'                  => 'Owner Associations',
        //
        'intro'                  => 'Manage your owner associations and related units from here.',
        'manager'                => 'Manager',
        'not_assigned'           => 'Not assigned',
        'my_units'               => 'My Units',
        'open_requests'          => 'Open Requests',
        'view_association'       => 'View Association',
        'my_requests'            => 'My Requests',
        'new_request'            => 'New Request',
        'no_associations'        => 'No Owner Associations',
        'no_associations_desc'   => 'You are not registered in any owner association yet.',
        //
        'show_intro'             => 'View details of this owner association and manage your units and requests.',
        'back_to_list'           => 'Back to Associations',
        'my_units_list'          => 'My Units',
        'manage_unit'            => 'Manage',
        'no_units'               => 'No units registered yet.',
        'total'                  => 'total',
        'submit_new'             => 'Submit new request now',
        'recent_requests'        => 'Recent Requests',
        'assigned_to'            => 'Assigned to',
        'all_requests'           => 'All My Requests',
        'completed'              => 'Completed',
        'total_requests'         => 'Total Requests',
        'view'                   => 'View',
        'no_address'             => 'No address available',
        // All Requests Page
        'my_requests_title'      => 'My Requests',
        'cancel_request'         => 'Cancel',
        'viewing_requests_for'   => 'Viewing requests for this association',
        'back'                   => 'Back',
        'unit'                   => 'Unit',
        'no_requests'            => 'No Requests Yet',
        'no_requests_desc'       => 'You have not submitted any requests for this association yet.',
        'create_first_request'   => 'Create Your First Request',
        // Requests Create Page
        'field_unit'             => 'Unit',
        'field_unit_placeholder' => 'Select a unit',
        'field_title'            => 'Title',
        'field_description'      => 'Notes & Description',
        'field_priority'         => 'Priority',
        'field_type'             => 'Request Type',
        'priority_normal'        => 'Normal',
        'field_attachments'      => 'Attachments',
        'cancel'                 => 'Cancel',
        'submit_request'         => 'Submit Request',
        // Show
        'request_details'        => 'Request Details',
        'request'                => 'Request',
        'request_type'           => 'Type',
        'request_priority'       => 'Priority',
        'request_status'         => 'Status',
        'created_at'             => 'Created At',
        // 'not_assigned_yet'       => 'Not assigned yet',
        'request_description'    => 'Description',
        'no_description'         => 'No description provided',
        'replies'                => 'Replies',
        'admin'                  => 'Admin',
        'you'                    => 'You',
        'no_replies_yet'         => 'No replies yet',
        'add_reply'              => 'Add Reply',
        'reply_placeholder'      => 'Type your message here...',
        'send_reply'             => 'Send Reply',

        // Page Choose Owner
        'create_request_title'   => 'To submit a new request:',
        'create_request_info'    => 'Please select the owners association linked to your unit first. After selecting the association, you will be directed to the request form to enter the details and submit it to the management.',

    ],

    /*
    |--------------------------------------------------------------------------
    | Profile
    |--------------------------------------------------------------------------
    */
    'profile'            => [
        'my'                            => 'Profile',
        'title'                         => 'Profile',
        // Form Update Personal Info & Response Messages
        'updated_successfully'          => 'Profile has been updated successfully.',
        'personal_info'                 => 'Personal Info',
        // Form Update Password & Response Messages
        'update_password'               => 'Update Password',
        'current_password'              => 'Current Password',
        'new_password'                  => 'New Password',
        'confirm_password'              => 'Confirm Password',
        'current_password_wrong'        => 'The current password is incorrect.',
        'password_updated_successfully' => 'Password updated successfully.',
        'show_hide_passwords'           => 'Show / Hide Passwords',
        //
        'name'                          => 'Name',
        'name_placeholder'              => 'First & Last Name',
        'email'                         => 'Email (Optional)',
        'phone'                         => 'Phone',
        'phone_number'                  => 'Phone Number',
        //
        'national_id'                   => 'National ID',
        'national_id_placeholder'       => 'Enter national ID',

        'birth_date'                    => 'Date of Birth',

        'national_address'              => 'National Address',
        'national_address_placeholder'  => 'Enter national address',
    ],

    /*
    |--------------------------------------------------------------------------
    | 
    |--------------------------------------------------------------------------
    */
    'interest'           => [
        'interest_submitted' => 'Interest Submitted',
        'no_interests_title' => 'You have not submitted any interests yet',
        'start_browsing'     => 'Start browsing now',
        'description'        => 'Here you can view all the interests you have previously submitted and track the status of each interest to see if our team has contacted you.',
    ],

    /*
    |--------------------------------------------------------------------------
    | 
    |--------------------------------------------------------------------------
    */
    'deals'              => [
        'empty_title' => 'No deals available yet',
        'description' => 'On this page, you can track all deals related to your account and view their current status and basic details.',
    ],

    /*
    |--------------------------------------------------------------------------
    | 
    |--------------------------------------------------------------------------
    */
    'email'              => [
        'verification_sent' => 'Verification email has been sent.',
        'not_verified'      => 'Your email address is not verified yet.',
        'verify_now'        => 'Verify email',
        'sending'           => 'Sending...',
    ],

    /*
    |--------------------------------------------------------------------------
    | 
    |--------------------------------------------------------------------------
    */
    'aside'              => [
        'account_overview'           => 'Overview',
        //  'my_account'       => 'My Account',
        'settings'                   => 'Settings',
        'logout'                     => 'Logout',
        'interests'                  => 'Interests',
        'deals'                      => 'Deals',
        'list_your_property'         => 'List your property',
        'owner_associations'         => 'Owner Associations',
        'owner_associations_request' => 'Create a Request',
        'owner_voting'               => 'Owners Voting',

        ''                           => '',

    ],

];
