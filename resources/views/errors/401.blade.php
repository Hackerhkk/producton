<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no"
    >

    <title>401 Unauthorized | {{ config('app.name', 'Library Management System') }}</title>
<link
        rel="icon"
        type="image/png"
        href="{{ asset('svg.svg') }}"
    >
    <meta name="robots" content="noindex, nofollow">

    <style>
        * {
            box-sizing: border-box;
        }

        html,
        body {
            width: 100%;
            height: 100%;
            margin: 0;
            padding: 0;
            overflow: hidden;
            background: #ffffff;
        }

        body {
            font-family: Helvetica, Arial, sans-serif;
        }

        #container {
            position: fixed;
            inset: 0;
            width: 100%;
            height: 100%;
            touch-action: none;
        }

        #container canvas {
            display: block;
            width: 100%;
            height: 100%;
        }

        .message {
            position: fixed;
            z-index: 10;
            left: 50%;
            bottom: 32px;
            width: min(92%, 520px);
            transform: translateX(-50%);
            text-align: center;
            padding: 18px 20px;
            color: #111827;
        }

        .message p {
            margin: 3px 0;
            line-height: 1.4;
        }

        .message .title {
            font-size: 24px;
            font-weight: 700;
            letter-spacing: -0.02em;
        }

        .message .subtitle {
            font-size: 14px;
            color: #667085;
        }

        .message .code {
            margin-top: 4px;
            font-size: 12px;
            font-weight: 600;
            color: #2874b9;
            letter-spacing: 0.08em;
            text-transform: uppercase;
        }

        .actions {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 10px;
            margin-top: 16px;
        }

        .action-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 7px;
            min-height: 42px;
            padding: 0 17px;
            border-radius: 10px;
            text-decoration: none;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            transition:
                transform 0.2s ease,
                background-color 0.2s ease,
                box-shadow 0.2s ease;
        }

        .action-btn:hover {
            transform: translateY(-1px);
        }

        .action-primary {
            color: #ffffff;
            background: #2874b9;
            box-shadow: 0 5px 16px rgba(40, 116, 185, 0.22);
        }

        .action-primary:hover {
            background: #205f98;
        }

        .action-secondary {
            color: #344054;
            background: rgba(255, 255, 255, 0.9);
            border: 1px solid #d0d5dd;
        }

        .action-secondary:hover {
            background: #f8fafc;
        }

        .action-btn svg {
            width: 17px;
            height: 17px;
            flex-shrink: 0;
        }

        .fallback {
            display: none;
            position: fixed;
            inset: 0;
            z-index: 50;
            align-items: center;
            justify-content: center;
            padding: 24px;
            background: #ffffff;
            text-align: center;
        }

        .fallback-card {
            max-width: 420px;
        }

        .fallback-card h1 {
            margin: 0 0 8px;
            font-size: 32px;
            color: #111827;
        }

        .fallback-card p {
            margin: 0 0 20px;
            color: #667085;
            line-height: 1.6;
        }

        @media (max-width: 640px) {
            .message {
                bottom: 18px;
                padding: 14px 14px;
            }

            .message .title {
                font-size: 21px;
            }

            .message .subtitle {
                font-size: 13px;
            }

            .actions {
                gap: 8px;
            }

            .action-btn {
                min-height: 40px;
                padding: 0 14px;
                font-size: 13px;
            }
        }

        @media (max-height: 600px) {
            .message {
                bottom: 10px;
                padding: 8px;
            }

            .message .title {
                font-size: 19px;
            }

            .message .subtitle {
                display: none;
            }

            .actions {
                margin-top: 10px;
            }
        }
    </style>
</head>

<body>

    <div id="container" touch-action="none"></div>

    <div class="message">
        <p class="title">Access denied</p>

        <p class="subtitle">
            All doors are closing. You are not authorized to access this page.
        </p>

        <p class="code">Error 401 · Unauthorized</p>

        <div class="actions">

            <a
                href="{{ route('login') }}"
                class="action-btn action-primary"
            >
                <svg
                    viewBox="0 0 24 24"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="2"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                >
                    <path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"/>
                    <polyline points="10 17 15 12 10 7"/>
                    <line x1="15" y1="12" x2="3" y2="12"/>
                </svg>

                Login
            </a>

            <a
                href="{{ url('/') }}"
                class="action-btn action-secondary"
            >
                <svg
                    viewBox="0 0 24 24"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="2"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                >
                    <path d="m3 9 9-6 9 6"/>
                    <path d="M5 10v10h14V10"/>
                    <path d="M9 20v-6h6v6"/>
                </svg>

                Home
            </a>

        </div>
    </div>

    <div id="fallback" class="fallback">
        <div class="fallback-card">
            <h1>401</h1>

            <p>
                You are not authorized to access this page.
            </p>

            <a
                href="{{ route('login') }}"
                class="action-btn action-primary"
            >
                Login
            </a>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/three.js/88/three.min.js"></script>

    <script id="vertexShader" type="x-shader/x-vertex">
        void main() {
            gl_Position = vec4(position, 1.0);
        }
    </script>

    <script id="fragmentShader" type="x-shader/x-fragment">

        uniform vec2 u_resolution;
        uniform float u_time;
        uniform vec2 u_mouse;
        uniform sampler2D u_plate;

        const float eps = 0.005;

        vec3 movement = vec3(.0);

        const int maxIterations = 256;
        const float stepScale = .7;
        const float stopThreshold = 0.001;

        const float PI = 3.14159;

        vec3 path(float delta) {
            return vec3(0., 0., -delta * 3.);
        }

        float length2(vec2 p) {
            return sqrt(p.x * p.x + p.y * p.y);
        }

        float length8(vec2 p) {
            p = p * p;
            p = p * p;
            p = p * p;

            return pow(p.x + p.y, 1.0 / 8.0);
        }

        float sdBox(vec3 p, vec3 b) {
            vec3 d = abs(p) - b;

            return min(
                max(d.x, max(d.y, d.z)),
                0.0
            ) + length(max(d, 0.0));
        }

        float udBox(vec3 p, vec3 b) {
            return length(max(abs(p) - b, 0.0));
        }

        float sdSphere(vec3 p, float s) {
            return length(p) - s;
        }

        float sdPlane(vec3 p) {
            return p.y;
        }

        vec3 random3(vec3 p) {
            return fract(
                sin(
                    vec3(
                        dot(p, vec3(127.1, 311.7, 319.8)),
                        dot(p, vec3(269.5, 183.3, 415.2)),
                        dot(p, vec3(362.9, 201.5, 134.7))
                    )
                ) * 43758.5453
            );
        }

        float world_sdf(in vec3 p) {

            float world = 10.;

            float pz = p.z;

            float delta = pz * .3;

            float s = sin(delta);
            float c = cos(delta);

            mat2 rot = mat2(c, -s, s, c);

            p.z = mod(p.z, 1.5) - .75;
            p.xy *= rot;

            float animationPath = path(u_time).z;

            float animation =
                smoothstep(
                    -2.,
                    -1.5,
                    animationPath - pz + p.z
                );

            const float wallWidth = .02;
            const float doorWidth = .23;

            world = udBox(
                p,
                vec3(5., 10., wallWidth)
            );

            world = min(
                world,
                udBox(
                    p + vec3(0., .5, 0.),
                    vec3(5., .05, wallWidth + .015)
                )
            );

            world = max(
                world,
                -sdBox(
                    p,
                    vec3(doorWidth, .5, 1.)
                )
            );

            world = min(
                world,
                p.y + .5
            );

            const float RAD90 = 1.5708;

            const float cospi = cos(PI);
            const float sinpi = sin(PI);

            const float cosrad90 = cos(RAD90);
            const float sinrad90 = sin(RAD90 * 1.1);

            c = mix(cospi, cosrad90, animation);
            s = mix(sinpi, sinrad90, animation);

            vec3 doorP = p;

            doorP.xz *= mat2(c, -s, s, c);

            doorP.x +=
                mix(
                    0.001,
                    doorWidth - .005,
                    animation
                );

            doorP.z +=
                mix(
                    0.,
                    doorWidth - .005,
                    animation
                );

            world = min(
                world,
                sdBox(
                    doorP,
                    vec3(
                        doorWidth - .005,
                        .5 - .005,
                        wallWidth
                    )
                )
            );

            vec3 plateoffset = vec3(0., -.2, 0.);

            vec2 plateUV =
                doorP.xy * vec2(-3., 3.)
                + .5
                + plateoffset.xy * 3.;

            float t =
                1. -
                texture2D(
                    u_plate,
                    plateUV
                ).x;

            world = min(
                world,
                sdBox(
                    doorP + plateoffset,
                    vec3(
                        doorWidth * .8,
                        .1,
                        wallWidth + .01 * t + .005
                    )
                )
            );

            doorP.x += .12;
            doorP.z -= .05;
            doorP.y += .05;

            world = min(
                world,
                sdSphere(
                    doorP,
                    .03
                )
            );

            return world;
        }

        vec3 calculate_normal(in vec3 p) {

            float gradient_x =
                world_sdf(
                    vec3(
                        p.x + eps,
                        p.y,
                        p.z
                    )
                )
                -
                world_sdf(
                    vec3(
                        p.x - eps,
                        p.y,
                        p.z
                    )
                );

            float gradient_y =
                world_sdf(
                    vec3(
                        p.x,
                        p.y + eps,
                        p.z
                    )
                )
                -
                world_sdf(
                    vec3(
                        p.x,
                        p.y - eps,
                        p.z
                    )
                );

            float gradient_z =
                world_sdf(
                    vec3(
                        p.x,
                        p.y,
                        p.z + eps
                    )
                )
                -
                world_sdf(
                    vec3(
                        p.x,
                        p.y,
                        p.z - eps
                    )
                );

            return normalize(
                vec3(
                    gradient_x,
                    gradient_y,
                    gradient_z
                )
            );
        }

        float rayMarching(
            vec3 origin,
            vec3 dir,
            float start,
            float end,
            inout float field
        ) {

            float sceneDist = 1e4;
            float rayDepth = start;

            for (
                int i = 0;
                i < maxIterations;
                i++
            ) {

                sceneDist =
                    world_sdf(
                        origin + dir * rayDepth
                    );

                if (
                    sceneDist < stopThreshold ||
                    rayDepth >= end
                ) {
                    break;
                }

                rayDepth +=
                    sceneDist * stepScale;
            }

            if (
                sceneDist >= stopThreshold
            ) {
                rayDepth = end;
            } else {
                rayDepth += sceneDist;
            }

            return rayDepth;
        }

        vec3 lighting(
            vec3 sp,
            vec3 camPos,
            int reflectionPass,
            float dist,
            float field,
            vec3 rd
        ) {

            vec3 sceneColor = vec3(0.0);
            vec3 objColor = vec3(1.);

            vec3 surfNormal =
                calculate_normal(sp);

            vec3 lp =
                vec3(-0., .3, -1.)
                + movement;

            vec3 ld = lp - sp;

            vec3 lcolor =
                vec3(1., .97, .92) * .5;

            float len = length(ld);

            ld /= len;

            float sceneLen =
                length(camPos - sp);

            float sceneAtten =
                min(
                    1.0 /
                    (
                        0.015 *
                        sceneLen *
                        sceneLen
                    ),
                    1.0
                );

            vec3 ref =
                reflect(
                    -ld,
                    surfNormal
                );

            float ambient = .3;

            float specularPower = 10.;

            float diffuse =
                max(
                    0.0,
                    dot(
                        surfNormal,
                        ld
                    )
                );

            float specular =
                max(
                    0.0,
                    dot(
                        ref,
                        normalize(camPos - sp)
                    )
                );

            specular =
                pow(
                    specular,
                    specularPower
                );

            sceneColor +=
                (
                    objColor *
                    (
                        diffuse * .8 +
                        ambient
                    )
                    +
                    specular * .5
                )
                *
                lcolor
                *
                1.3;

            sceneColor =
                mix(
                    sceneColor,
                    vec3(1.),
                    1. -
                    sceneAtten *
                    sceneAtten
                );

            return sceneColor;
        }

        void main() {

            vec2 aspect =
                vec2(
                    u_resolution.x /
                    u_resolution.y,
                    1.0
                );

            vec2 uv =
                (
                    2.0 *
                    gl_FragCoord.xy /
                    u_resolution.xy
                    - 1.0
                )
                * aspect;

            movement =
                path(u_time);

            vec3 lookAt =
                vec3(-0., 0.2, 1.);

            vec3 camera_position =
                vec3(0., 0., -1.0);

            lookAt += movement;
            camera_position += movement;

            vec3 forward =
                normalize(
                    lookAt -
                    camera_position
                );

            vec3 right =
                normalize(
                    vec3(
                        forward.z,
                        0.,
                        -forward.x
                    )
                );

            vec3 up =
                normalize(
                    cross(
                        forward,
                        right
                    )
                );

            float FOV = 0.6;

            vec3 ro = camera_position;

            vec3 rd =
                normalize(
                    forward +
                    FOV * uv.x * right +
                    FOV * uv.y * up
                );

            const float clipNear = 0.0;
            const float clipFar = 8.0;

            float field = 0.;

            float dist =
                rayMarching(
                    ro,
                    rd,
                    clipNear,
                    clipFar,
                    field
                );

            if (dist >= clipFar) {
                gl_FragColor =
                    vec4(
                        vec3(1.),
                        1.0
                    );

                return;
            }

            vec3 sp =
                ro + rd * dist;

            vec3 sceneColor =
                lighting(
                    sp,
                    camera_position,
                    0,
                    dist,
                    field,
                    rd
                );

            gl_FragColor =
                vec4(
                    clamp(
                        sceneColor,
                        0.0,
                        1.0
                    ),
                    1.0
                );
        }

    </script>

    <script>
        let container;
        let camera;
        let scene;
        let renderer;
        let uniforms;

        const loader = new THREE.TextureLoader();

        loader.setCrossOrigin("anonymous");

        loader.load(
            'https://s3-us-west-2.amazonaws.com/s.cdpn.io/982762/noise.png',

            function (texture) {

                texture.wrapS = THREE.RepeatWrapping;
                texture.wrapT = THREE.RepeatWrapping;
                texture.minFilter = THREE.LinearFilter;

                loader.load(
                    'https://s3-us-west-2.amazonaws.com/s.cdpn.io/982762/403-2.png',

                    function (plate) {
                        init(texture, plate);
                        animate();
                    },

                    undefined,

                    function () {
                        showFallback();
                    }
                );
            },

            undefined,

            function () {
                showFallback();
            }
        );

        function init(texture, plate) {

            container =
                document.getElementById('container');

            camera =
                new THREE.Camera();

            camera.position.z = 1;

            scene =
                new THREE.Scene();

            const geometry =
                new THREE.PlaneBufferGeometry(2, 2);

            uniforms = {

                u_time: {
                    type: "f",
                    value: 1.0
                },

                u_resolution: {
                    type: "v2",
                    value: new THREE.Vector2()
                },

                u_plate: {
                    type: "t",
                    value: plate
                },

                u_mouse: {
                    type: "v2",
                    value: new THREE.Vector2()
                }

            };

            const material =
                new THREE.ShaderMaterial({

                    uniforms: uniforms,

                    vertexShader:
                        document.getElementById(
                            'vertexShader'
                        ).textContent,

                    fragmentShader:
                        document.getElementById(
                            'fragmentShader'
                        ).textContent

                });

            material.extensions.derivatives = true;

            const mesh =
                new THREE.Mesh(
                    geometry,
                    material
                );

            scene.add(mesh);

            renderer =
                new THREE.WebGLRenderer({
                    antialias: true,
                    alpha: false
                });

            renderer.setPixelRatio(
                Math.min(
                    window.devicePixelRatio || 1,
                    2
                )
            );

            container.appendChild(
                renderer.domElement
            );

            onWindowResize();

            window.addEventListener(
                'resize',
                onWindowResize,
                false
            );

            document.addEventListener(
                'pointermove',
                function (event) {

                    if (!uniforms) {
                        return;
                    }

                    const ratio =
                        window.innerHeight /
                        window.innerWidth;

                    uniforms.u_mouse.value.x =
                        (
                            event.pageX -
                            window.innerWidth / 2
                        )
                        /
                        window.innerWidth
                        /
                        ratio;

                    uniforms.u_mouse.value.y =
                        (
                            event.pageY -
                            window.innerHeight / 2
                        )
                        /
                        window.innerHeight
                        *
                        -1;
                }
            );
        }

        function onWindowResize() {

            if (!renderer || !uniforms) {
                return;
            }

            renderer.setSize(
                window.innerWidth,
                window.innerHeight
            );

            uniforms.u_resolution.value.x =
                renderer.domElement.width;

            uniforms.u_resolution.value.y =
                renderer.domElement.height;
        }

        function animate() {

            requestAnimationFrame(
                animate
            );

            render();
        }

        function render() {

            if (!renderer || !uniforms) {
                return;
            }

            uniforms.u_time.value += 0.01;

            renderer.render(
                scene,
                camera
            );
        }

        function showFallback() {

            document.getElementById(
                'container'
            ).style.display = 'none';

            document.getElementById(
                'fallback'
            ).style.display = 'flex';
        }
    </script>

</body>
</html>
