 
    <div class="header-navbar">
        <div class="header-wrap">
            <div class="header-bottom row">
                <nav>
                  <label for="drop" class="toggle">Menu</label>
                  <input type="checkbox" id="drop" />
                  <ul class="menu">
                      @foreach ($objectNiveaux as $index=>$objectNiveau) 
                        <li>
                            <label for="drop-{{$index+1}}" class="toggle">{{ $objectNiveau['Name'] }} <span class="caret"></span></label>
                            <a href="{{url('/programme/'.$objectNiveau['name'])}}">{{ $objectNiveau['Name'] }}<span class="caret"></span></a>
                            <input type="checkbox" id="drop-{{$index+1}}"/>
                            <ul>
                              @foreach ($objectMatieres as $objectMatiere)
                                <li><a href="{{ url('/programme/'.$objectNiveau['name'].'/'.$objectMatiere['href']) }}">{{ $objectMatiere['Name'] }}</a></li>
                              @endforeach
                            </ul>
                        </li>
                        @endforeach
                        <li id="link-bomberman"><a href="{{url('/bomberman')}}">Bomberman</a></li>
                  </ul>
                </nav>
                
<!--
                <nav class="navbar navbar-default" role="navigation">
                  <div class="container-fluid ">
                    <div class="navbar-header">
                        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1"> <span class="sr-only"> Toggle navigation </span>
                           <span class="icon-bar icon-bar1"></span>
                           <span class="icon-bar icon-bar2"></span>
                           <span class="icon-bar icon-bar3"></span>
                        </button>

                    </div>
                    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                      <ul class="nav navbar-nav">

                        @foreach ($objectNiveaux as $objectNiveau)   
                        <li class="dropdown">
                          <a href="{{url('/programme/'.$objectNiveau['name'])}}" class="dropdown-toggle">{{ $objectNiveau['Name'] }}<span class="caret"></span></a>
                          <ul class="dropdown-menu">
                              @foreach ($objectMatieres as $objectMatiere)
                                <li><a href="{{ url('/programme/'.$objectNiveau['name'].'/'.$objectMatiere['href']) }}">{{ $objectMatiere['Name'] }}</a></li>
                              @endforeach
                          </ul>
                        </li>
                        @endforeach
                          
                      </ul>
                    </div>
                  </div>
                </nav> 
-->
            </div>
        </div><!-- end header-wrap2-->
    </div>