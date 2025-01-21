<span class="d-flex align-items-center">
                            <img class="rounded-circle header-profile-user"
                                 src="{{get_file(auth()->guard('trader')->user()->logo)}}"
                                 alt="Header Avatar">
                            <span class="text-start ms-xl-2">
                                <span
                                    class="d-none d-xl-inline-block ms-1 fw-medium user-name-text">{{auth()->guard('trader')->user()->name}}</span>
                                <span
                                    class="d-none d-xl-block ms-1 fs-12 text-muted user-name-sub-text">{{auth()->guard('market')->user()->business_name}}</span>
                            </span>
                        </span>  </span>
