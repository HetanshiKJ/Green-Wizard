let scene;
let camera;
let renderer;

function main() {
  const canvas = document.querySelector('#canvas');

  scene = new THREE.Scene();

  camera = new THREE.PerspectiveCamera(45, window.innerWidth / window.innerHeight, 0.1, 1000);
  camera.position.z = 2;
  scene.add(camera);

  renderer = new THREE.WebGLRenderer({ canvas: canvas, antialias: true });
  renderer.setSize(window.innerWidth, window.innerHeight);
  renderer.setPixelRatio(window.devicePixelRatio);

  renderer.autoClear = false;
  renderer.setClearColor(0x000000, 0.0); // Set to black initially to avoid the white background

  // Create a loading manager to preload textures
  const loaderManager = new THREE.LoadingManager();

  loaderManager.onStart = function (url, itemsLoaded, itemsTotal) {
    console.log(`Started loading: ${url}`);
  };

  loaderManager.onLoad = function () {
    console.log("All textures loaded.");
    animate(); // Start animation once textures are loaded
  };

  loaderManager.onError = function (url) {
    console.log(`Error loading: ${url}`);
  };

  // Load textures using the loading manager
  const earthTexture = new THREE.TextureLoader(loaderManager).load('./img/eart.jpg');
  const bumpTexture = new THREE.TextureLoader(loaderManager).load('./img/specularmap.jpg');
  const galaxyTexture = new THREE.TextureLoader(loaderManager).load('./img/galaxy.png');
  const cloudTexture = new THREE.TextureLoader(loaderManager).load('./img/earthCloud.png');

  // Create earth geometry
  const earthGeometry = new THREE.SphereGeometry(0.5, 30, 30);

  const earthMaterial = new THREE.MeshPhongMaterial({
    roughness: 1, // Reduced roughness for more shine
    metalness: 0, // Added some metalness for a slight metallic 
    map: earthTexture,
    bumpMap: bumpTexture,
    bumpScale: 0.3,
    emissive: 0x00000, 
    emissiveIntensity: 0,
  });

  const earthMesh = new THREE.Mesh(earthGeometry, earthMaterial);
  earthMesh.position.set(0.7, 0, 0);
  scene.add(earthMesh);
  
//   //clouds 
//   const cloudGeometry = new THREE.SphereGeometry(0.51, 30, 30); // Slightly larger than Earth
//   const cloudMaterial = new THREE.MeshPhongMaterial({
//   map: cloudTexture, // Cloud texture
//   transparent: true, // Clouds need transparency
//   opacity: 0.8,
//   });
//   const cloudMesh = new THREE.Mesh(cloudGeometry, cloudMaterial);
//   cloudMesh.position.set(0.7, 0, 0);
//   scene.add(cloudMesh);

//   // Rotate clouds slightly faster for realism
//   function animateClouds() {
//   cloudMesh.rotation.y += 0.008; // Slow rotation for clouds
// }



      // Neon Glow Effect (Custom Shader)
      const glowGeometry = new THREE.SphereGeometry(0.7, 30, 30);
      const glowMaterial = new THREE.ShaderMaterial({
        uniforms: {
          glowColor: { value: new THREE.Color(0x00aaff) },
          coefficient: { value: 0.5 },
          power: { value: 5.0 }
        },
        vertexShader: `
          varying vec3 vNormal;
          void main() {
            vNormal = normalize(normalMatrix * normal);
            gl_Position = projectionMatrix * modelViewMatrix * vec4(position, 1.0);
          }
        `,
        fragmentShader: `
          uniform vec3 glowColor;
          uniform float coefficient;
          uniform float power;
          varying vec3 vNormal;
          void main() {
            float intensity = pow(coefficient - dot(vNormal, vec3(0.0, 0.0, 1.0)), power);
            gl_FragColor = vec4(glowColor, 1.0) * intensity;
          }
        `,
        side: THREE.BackSide,
        blending: THREE.AdditiveBlending,
        transparent: true,
        opacity: 0.2
      });
      
      const glowMesh = new THREE.Mesh(glowGeometry, glowMaterial);
      glowMesh.position.set(0.8, 0, 0.1);
      scene.add(glowMesh);

  // Set ambient light
  const ambientLight = new THREE.AmbientLight(0xffffff, 0.4); // Increased ambient light intensity
  ambientLight.intensity = 0.6;
  scene.add(ambientLight);

  // Set point light
  const pointLight = new THREE.PointLight(0xffffff, 1.2); // Increased point light intensity
  pointLight.position.set(5, 5, 5);
  pointLight.intensity = 1;
  scene.add(pointLight);

  //spot light
  const spotLight = new THREE.SpotLight(0xffffff, 1.2);
  spotLight.position.set(20, 15, 20);
  spotLight.intensity = 1;
  scene.add(spotLight);

  //directional light
  const directionalLight = new THREE.DirectionalLight(0xffffff, 1);
  directionalLight.position.set(10, 10, 10);
  directionalLight.intensity = 1;
  scene.add(directionalLight);


  // Animate function
  const animate = () => {
    requestAnimationFrame(animate);
    earthMesh.rotation.y -= 0.005;
    // animateClouds();
    

    render();
  };

  // Render function
  const render = () => {
    renderer.render(scene, camera);
  };
}

window.onload = main;

window.addEventListener('resize', function () {
  const width = window.innerWidth;
  const height = window.innerHeight;
  
  renderer.setSize(width, height);
  camera.aspect = width / height;
  camera.updateProjectionMatrix();
});
