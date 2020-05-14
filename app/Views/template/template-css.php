<style>

/* structure */
html,
body {
  height: 100%;
}

p {
  text-align: justify;
}


#navbar {
  position: fixed;
  top: 0px;
  width: 100%;
  height: 50px;
  z-index: 1000;
}

#navbar img {
  width: 40px;
  height: 40px;
}

#login    .dropdown-menu .form-group input,
#register .dropdown-menu .form-group input {
  width: 200px;
}


#sidebar {
  position: fixed;
  margin-left: -250px;
  top: 50px;
  width: 250px;
  height: 100%;
  z-index: 1000;
}

#sidebar.active {
  margin-left: 0px;
}

#sidebar-dismiss {
  position: absolute;
  top: 10px;
  right: 10px;
  width: 35px;
  height: 35px;
  text-align: center;
}

#sidebar a {
  display: block;
}
#sidebar a[data-toggle="collapse"] {
  position: relative;
}


#content {
  flex: 1 0 auto;
  margin-top: 5rem;
}


#footer {
  flex-shrink: none;
  text-align: center;
}



/* colours */
:root {
  --body-color: #fafafa;
  --p-color: #999999;

  --navbar-color: #7386d5;
  --navbar-accent-color: #6b80d3;
  --navbar-border-color: #455bb1;

  --sidebar-color: #7386d5;
  --sidebar-header-color: #6d7fcc;
  --sidebar-accent-color: #5d6baa;
  --sidebar-text-color: #ffffff;
}



/* style */
body {
  font-family: sans-serif;
  background: var(--body-color);
}

p {
  font-size: 1.1em;
  line-height: 1.7em;
  color: var(--p-color);
}

a,
a:hover,
a:focus {
  text-decoration: none;
  color: inherit;
}


#navbar {
  background-color: var(--navbar-color);
}
#navbar-content > * {
  white-space: nowrap;
  padding: 9px;
  align-self: center;
}
#navbar .brand {
  padding: 5px;
}
#navbar .button {
  border-radius: unset;
}
#navbar .button .active,
#navbar .button:hover {
  background-color: var(--navbar-accent-color);
  border-bottom: 4px solid var(--navbar-border-color);
}

#login    .dropdown-menu .form-group label,
#register .dropdown-menu .form-group label {
  margin-bottom: 2px;
  font-size: 12px;
}


#sidebar {
  background: var(--sidebar-color);
  color: var(--sidebar-text-color);
}

#sidebar .sidebar-header {
  padding: 20px;
  background: var(--sidebar-header-color);
}

#sidebar-dismiss {
  line-height: 35px;
  cursor: pointer;
  background: var(--sidebar-color);
}
#sidebar-dismiss:hover {
  background: var(--sidebar-text-color);
  color: var(--sidebar-color);
}

#sidebar ul p {
  padding: 10px;
  color: var(--sidebar-text-color);
}

#sidebar ul.components {
  padding: 20px 0px;
}

#sidebar ul li a {
  padding: 10px;
  font-size: 1.1em;
}
#sidebar ul li a:hover {
  background: var(--sidebar-text-color);
  color: var(--sidebar-color);
}

#sidebar ul ul a {
  font-size: 0.9em !important;
  padding-left: 30px !important;
  background: var(--sidebar-accent-color);
}



/* animations */
#sidebar,
#sidebar-dismiss,
#sidebar a,
#sidebar a:hover,
#sidebar a:focus {
  -webkit-transition: all 0.3s; /* Safari */
  -o-transition: all 0.3s; /* Opera */
  transition: all 0.3s; /* Firefox, Chrome, ... */
}



/* utilities */
.noselect {
  -webkit-touch-callout: none; /* iOS Safari */
  -webkit-user-select: none; /* Safari */
  -khtml-user-select: none; /* Konqueror HTML */
  -moz-user-select: none; /* Old versions of Firefox */
  -ms-user-select: none; /* Internet Explorer/Edge */
  user-select: none; /* Non-prefixed version, currently supported by Chrome, Opera and Firefox */
}

.spacer {
  flex-grow: 1;
}

</style>

